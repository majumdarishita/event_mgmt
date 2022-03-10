<?php

namespace App\Http\Controllers;

use App\EventMaster;
use DateInterval;
use DatePeriod;
use DateTime;
use Exception;
use Illuminate\Http\Request;

class EventMasterController extends Controller
{
    public function index()
    {
        return view('event_master.view_event_master')->with('event_masters', EventMaster::where('is_active', 1)->get());
    }

    public function create()
    {
        return view('event_master.create_event_master')->with(['occurrence_every' => EventMaster::occurrenceEvery(), 'occurrence_every_period' => EventMaster::occurrenceEveryPeriod(), 'occurrence_duration' => EventMaster::occurrenceDuration(), 'occurrence_weekday' => EventMaster::occurrenceWeekday(), 'occurrence_monthly' => EventMaster::occurrenceMonthly()]);
    }

    public function rule($request)
    {
        return $request->validate([
            'title' => 'required|min:1|max:250',
            'start_date' => 'required',
            'end_date' => 'required',
            'occurrence_repeat' => 'sometimes',
            'occurrence_every' => 'required_if:occurrence_repeat,1',
            'occurrence_every_period' => 'required_if:occurrence_repeat,1',
            'occurrence_duration' => 'required_if:occurrence_repeat,0',
            'occurrence_weekday' => 'required_if:occurrence_repeat,0',
            'occurrence_monthly' => 'required_if:occurrence_repeat,0',

        ]);
    }
    public function store(Request $request)
    {
        if ($this->rule($request)) {
            try {
                $event_master = new EventMaster();
                $event_master->title = $request->title;
                $event_master->start_date = $request->start_date != "" ? date_format(date_create($request->start_date), 'Y-m-d') : null;
                $event_master->end_date = $request->end_date != "" ? date_format(date_create($request->end_date), 'Y-m-d') : null;
                $event_master->occurrence_repeat = $request->occurrence_repeat;
                if ($request->occurrence_repeat) {
                    $event_master->occurrence_every = $request->occurrence_every;
                    $event_master->occurrence_every_period = $request->occurrence_every_period;
                } else {
                    $event_master->occurrence_duration = $request->occurrence_duration;
                    $event_master->occurrence_weekday = $request->occurrence_weekday;
                    $event_master->occurrence_monthly = $request->occurrence_monthly;
                }
                if ($event_master->save()) {
                    return redirect('event_master')->withErrors(['message' => trans('string.event_saved'), 'class' => 'success']);
                }

                return redirect('event_master/create')->withErrors(['message' => trans('string.something_wrong'), 'class' => 'danger']);

            } catch (Exception $ex) {
                return redirect('event_master/create')->withErrors(['message' => trans('string.something_wrong'), 'class' => 'danger']);
            }
        }
    }

    public function edit($id)
    {
        return view('event_master.edit_event_master')->with(['event_master' => EventMaster::find($id), 'occurrence_every' => EventMaster::occurrenceEvery(), 'occurrence_every_period' => EventMaster::occurrenceEveryPeriod(), 'occurrence_duration' => EventMaster::occurrenceDuration(), 'occurrence_weekday' => EventMaster::occurrenceWeekday(), 'occurrence_monthly' => EventMaster::occurrenceMonthly()]);
    }

    public function update($id, Request $request)
    {
        if ($this->rule($request)) {
            try {
                $event_master = EventMaster::find($id);
                if (isset($event_master) && $event_master->is_active == 1) {
                    $event_master->title = $request->title;
                    $event_master->start_date = $request->start_date != "" ? date_format(date_create($request->start_date), 'Y-m-d') : null;
                    $event_master->end_date = $request->end_date != "" ? date_format(date_create($request->end_date), 'Y-m-d') : null;
                    $event_master->occurrence_repeat = $request->occurrence_repeat;
                    if ($request->occurrence_repeat) {
                        $event_master->occurrence_every = $request->occurrence_every;
                        $event_master->occurrence_every_period = $request->occurrence_every_period;
                        $event_master->occurrence_duration = $event_master->occurrence_weekday = $event_master->occurrence_monthly = null;
                    } else {
                        $event_master->occurrence_duration = $request->occurrence_duration;
                        $event_master->occurrence_weekday = $request->occurrence_weekday;
                        $event_master->occurrence_monthly = $request->occurrence_monthly;
                        $event_master->occurrence_every = $event_master->occurrence_every_period = null;
                    }
                    if ($event_master->save()) {
                        return redirect('event_master')->withErrors(['message' => trans('string.event_updated'), 'class' => 'success']);
                    }

                    return redirect()->back()->withErrors(['message' => trans('string.something_wrong'), 'class' => 'danger']);
                }
                return redirect('event_master')->withErrors(['message' => trans('string.no_data_found'), 'class' => 'danger']);

            } catch (Exception $ex) {
                return redirect()->back()->withErrors(['message' => trans('string.something_wrong'), 'class' => 'danger']);
            }
        }
    }

    public function destroy($id)
    {
        $event_master = EventMaster::find($id);
        if (isset($event_master) && $event_master->is_active == 1) {
            $event_master->is_active = 0;
            if ($event_master->save()) {
                return redirect('event_master')->withErrors(['message' => trans('string.event_deleted'), 'class' => 'success']);
            }

        }
        return redirect('event_master')->withErrors(['message' => trans('string.no_data_found'), 'class' => 'danger']);
    }

    public function show($id)
    {
        $event_master = EventMaster::find($id);
        if (isset($event_master) && $event_master->is_active == 1) {
            $dates = [];

            if ($event_master->occurrence_repeat==1) {
               $event_occurrence= [
                'Every'=>1,
                'Every Other'=>2,
                'Every Third'=>3,
                'Every Fourth'=>4
               ];
               $event_occurrence_period= [
                'Day'=>'D',
                'Week'=>'W',
                'Month'=>'M',
                'Year'=>'Y'
            ];
            $dates = $this->dates($event_master->start_date, $event_master->end_date, new DateInterval('P'.$event_occurrence[$event_master->occurrence_every].$event_occurrence_period[$event_master->occurrence_every_period]));
               

            } else {
                $duration= [
                'Month'=>'1M',
                '3 Months'=>'3M',
                '4 Months'=>'4M',
                '6 Months'=>'6M',
                'Year'=>'1Y'];
                $dates = $this->dates_on_occation($event_master, new DateInterval('P'.$duration[$event_master->occurrence_monthly]));

            }
            return view('event_master.show_event_master')->with('dates', $dates);
        }
        return redirect('event_master')->withErrors(['message' => trans('string.no_data_found'), 'class' => 'danger']);
    }

    public function dates($start_date, $end_date, $interval)
    {
        $dateRange = new DatePeriod(new DateTime($start_date), $interval, new DateTime($end_date));
        $date = [];
        foreach ($dateRange as $day) {
            $date[] = [
                'date' => $day->format('d-m-Y'),
                'day_name' => $day->format('D'),
            ];
        }
        return $date;
    }

    public function dates_on_occation($event_master,$interval)
    {
        $dateRange = new DatePeriod(new DateTime($event_master->start_date), $interval, new DateTime($event_master->end_date));
        $date = [];
        foreach ($dateRange as $day) {
            $date[] = [
                'date' => date('d-m-Y',strtotime($event_master->occurrence_duration.' '.$event_master->occurrence_weekday.' of '.$day->format('d-m-Y') )),
                'day_name' => date('D',strtotime($event_master->occurrence_duration.' '.$event_master->occurrence_weekday.' of '.$day->format('d-m-Y') )),
            ];
        }
        return $date;
    }
     

    
}
