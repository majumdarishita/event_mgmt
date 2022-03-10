<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{trans('string.event_list')}}</title>
    {{-- Css --}}
    <link rel="stylesheet" href="{{URL::asset('css/bootstrap.min.css')}}">
    {{-- JS --}}
    <script src="{{URL::asset('js/jquery.min.js')}}"></script>
</head>
<body>

    <div class="container-fluid" style="margin: 5%">
        <div class="panel panel-default">
            <div class="panel-heading">
                {{ trans('string.event_list') }}
                <span class="pull-right">
                    <a href="{{url('event_master/create')}}" class="btn btn-primary btn-sm">{{ trans('string.add_event') }}</a>
                </span>
            </div>
            <div class="panel-body">
                @if($errors->any())
                <div class="alert alert-{{$errors->first('class')!=""?$errors->first('class'):'danger'}} alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                      {{$errors->first()}}
                  </div>
                @endif
                <div class="col-sm-12 table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ trans('string.title') }}</th>
                                <th>{{trans('string.dates')}}</th>
                                <th>{{ trans('string.occurrence') }}</th>
                                <th>{{ trans('string.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($event_masters) && count($event_masters)>0)
                               @php $i=1 @endphp
                               @foreach($event_masters as $event_master)
                                   <tr>
                                       <td>{{$i++}}</td>
                                       <td>{{$event_master->title}}</td>
                                       <td>{{$event_master->start_date.' - '.$event_master->end_date}}</td>
                                       <td>
                                           @if($event_master->occurrence_repeat)
                                           {{$event_master->occurrence_every." ". $event_master->occurrence_every_period}}
                                           @else
                                          {{ trans('string.every') }} {{$event_master->occurrence_duration." ". $event_master->occurrence_weekday." ".trans('string.of_the')."  ".$event_master->occurrence_monthly}}

                                           @endif     
                                    </td>
                                       <td>
                                           <a href="{{url('event_master/'.$event_master->id)}}" class="btn btn-sm btn-success">{{ trans('string.view') }}</a>
                                           <a href="{{url('event_master/'.$event_master->id.'/edit')}}" class="btn btn-sm btn-primary">{{ trans('string.edit') }}</a>
                                           <a data-id="{{$event_master->id}}" class="btn btn-sm btn-danger btnDelete">{{ trans('string.delete') }}</a>
                                       </td>
                                   </tr>
                               @endforeach
                            @else
                            <tr>
                                <th colspan="5">{{ trans('string.no_data_found') }}</th>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="{{URL::asset('js/bootstrap.min.js')}}"></script>
    <script>
        $(document).on('click','.btnDelete',function(){
            if(confirm("{{trans('string.confirm_event_delete')}}")){
                window.location.href="{{url('delete_event')}}/"+($(this).data('id'));
            }
        });
    </script>
</body>
</html>
