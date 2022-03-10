<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{trans('string.show_event')}}</title>
    {{-- Css --}}
    <link rel="stylesheet" href="{{URL::asset('css/bootstrap.min.css')}}">
    {{-- JS --}}
    <script src="{{URL::asset('js/jquery.min.js')}}"></script>
</head>
<body>

    <div class="container-fluid" style="margin: 5%">
        <ul class="breadcrumb">
            <li><a href="{{url('event_master')}}">{{ trans('string.event_list') }}</a></li>
            <li>{{ trans('string.show_event') }}</li>
        </ul>
        <div class="panel panel-default">
            <div class="panel-heading">
                {{ trans('string.show_event') }}
            </div>
            <div class="panel-body">
                @if($errors->any())
                <div class="alert alert-{{$errors->first('class')!=""?:'danger'}} alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                      {{$errors->first()}}
                  </div>
                @endif
                @if(isset($dates) && count($dates)>0)
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>{{trans('string.date')}}</th>
                            <th>{{trans('string.day_name')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dates as $date)
                            <tr>
                                <td>{{$date['date']}}</td>
                                <td>{{$date['day_name']}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <h4>Total Recurrence Event: {{count($dates)}}</h4>
                @else
                <h4 class="text-center">{{ trans('string.no_data_found') }}</h4>
                @endif
                
        </div>
    </div>
</body>
</html>

