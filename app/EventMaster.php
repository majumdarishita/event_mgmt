<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventMaster extends Model
{

    public function scopeOccurrenceEvery(){
        return [
            'Every'=>'Every',
            'Every Other'=>'Every Other',
            'Every Third'=>'Every Third',
            'Every Fourth'=>'Every Fourth'
        ];
    }
    public function scopeOccurrenceEveryPeriod(){
        return [
            'Day'=>'Day',
            'Week'=>'Week',
            'Month'=>'Month',
            'Year'=>'Year'
        ];
    }
    public function scopeOccurrenceDuration(){
        return [
            'First'=>'First',
            'Second'=>'Second',
            'Third'=>'Third',
            'Fourth'=>'Fourth'
        ];
    }
    public function scopeOccurrenceWeekday(){
        return [
            'Sunday'=>'Sunday',
            'Monday'=>'Monday',
            'Tuesday'=>'Tuesday',
            'Wednesday'=>'Wednesday',
            'Thursday'=>'Thursday',
            'Friday'=>'Friday',
            'Saturday'=>'Saturday'
        ];
    }
    public function scopeOccurrenceMonthly(){
        return [
            'Month'=>'Month',
            '3 Months'=>'3 Months',
            '4 Months'=>'4 Months',
            '6 Months'=>'6 Months',
            'Year'=>'Year'
        ];
    }
}
