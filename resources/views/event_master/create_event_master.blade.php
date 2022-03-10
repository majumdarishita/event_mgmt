<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{trans('string.add_event')}}</title>
    {{-- Css --}}
    <link rel="stylesheet" href="{{URL::asset('css/bootstrap.min.css')}}">
    {{-- JS --}}
    <script src="{{URL::asset('js/jquery.min.js')}}"></script>
</head>
<body>

    <div class="container-fluid" style="margin: 5%">
        <ul class="breadcrumb">
            <li><a href="{{url('event_master')}}">{{ trans('string.event_list') }}</a></li>
            <li>{{ trans('string.add_event') }}</li>
        </ul>
        <div class="panel panel-default">
            <div class="panel-heading">
                {{ trans('string.add_event') }}
            </div>
            <div class="panel-body">
                @if($errors->any())
                <div class="alert alert-{{$errors->first('class')!=""?$errors->first('class'):'danger'}} alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                      {{$errors->first()}}
                  </div>
                @endif
                {!!Form::open(['url'=>'event_master','method'=>'post','id'=>'add_event']) !!}
                <div class="col-sm-12">
                    <div class="form-group">
                        {!!Form::label('title',trans('string.title'))!!}
                        {!!Form::text('title',null,['class'=>'form-control required','required','maxlength'=>250,'placeholder'=>trans('string.title'),'data-placeholder'=>trans('string.title')])!!}
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        {!!Form::label('start_date',trans('string.start_date'))!!}
                        {!!Form::date('start_date',null,['class'=>'form-control required','required','placeholder'=>trans('string.start_date'),'data-placeholder'=>trans('string.start_date')])!!}
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        {!!Form::label('end_date',trans('string.end_date'))!!}
                        {!!Form::date('end_date',null,['class'=>'form-control required','required','placeholder'=>trans('string.end_date'),'data-placeholder'=>trans('string.end_date')])!!}
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        {!!Form::label('reoccurrence',trans('string.reoccurrence'))!!}
                        <div class="col-sm-12">
                            <div class="col-sm-4">
                                <label for="repeat">
                                    {!!Form::radio('occurrence_repeat',1,true,['id'=>'repeat'])!!}
                                    {{ trans('string.repeat') }}
                                </label>
                            </div>
                            <div class="col-sm-4">
                                  {!!Form::select('occurrence_every',$occurrence_every,null,['id'=>'occurrence_every','class'=>' form-control required repeat','required','placeholder'=>trans('string.occurrence_every'),'data-placeholder'=>trans('string.occurrence_every')])!!}
                            </div>
                            <div class="col-sm-4">
                                {!!Form::select('occurrence_every_period',$occurrence_every_period,null,['id'=>'occurrence_every_period','class'=>' form-control required repeat','required','placeholder'=>trans('string.occurrence_every_period'),'data-placeholder'=>trans('string.occurrence_every_period')])!!}
                            </div>
                        </div>
                        <div class="col-sm-12" style="margin-top:2%">
                            <div class="col-sm-4">
                                <label for="repeat_on_occation">
                                    {!!Form::radio('occurrence_repeat',0,false,['id'=>'repeat_on_occation'])!!}
                                    {{ trans('string.repeat_on_occation') }}
                                </label>
                            </div>
                            <div class="col-sm-2">
                                {!!Form::select('occurrence_duration',$occurrence_duration,null,['id'=>'occurrence_duration','class'=>' form-control repeat_on_occation','disabled','placeholder'=>trans('string.occurrence_duration'),'data-placeholder'=>trans('string.occurrence_duration')])!!}
                            </div>
                            <div class="col-sm-2">
                                {!!Form::select('occurrence_weekday',$occurrence_weekday,null,['id'=>'occurrence_weekday','class'=>' form-control repeat_on_occation','disabled','placeholder'=>trans('string.occurrence_weekday'),'data-placeholder'=>trans('string.occurrence_weekday')])!!}
                            </div>
                            <div class="col-sm-1">
                                {{ trans('string.of_the') }}
                            </div>
                            <div class="col-sm-3">  
                                {!!Form::select('occurrence_monthly',$occurrence_monthly,null,['id'=>'occurrence_monthly','class'=>' form-control repeat_on_occation','disabled','placeholder'=>trans('string.occurrence_monthly'),'data-placeholder'=>trans('string.occurrence_monthly')])!!}
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-sm-12 text-center" style="margin-top: 2%">
                    <a href="{{url('event_master/create')}}" class="btn btn-danger btn-sm">{{ trans('string.reset') }}</a>
                    <button type="submit" class="btn btn-success btn-sm">{{ trans('string.submit') }}</button>
                </div>
                {!!Form::close()!!}
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

        });

        $('#start_date').on('change', function() {
            if ($(this).val() != "")
                $('#end_date').attr('min', $(this).val());
            else
                $('#end_date').attr('min', null);
        });

        $('#end_date').on('change', function() {
            if ($(this).val() != "")
                $('#start_date').attr('max', $(this).val());
            else
                $('#start_date').attr('max', null);
        });

        $("input[name='occurrence_repeat']").on('change',function(){
             if($("input[name='occurrence_repeat']:checked").val()==1){
                 $('.repeat').addClass('required');
                 $('.repeat').removeAttr('disabled');
                 $('.repeat').attr('required',true);
                 $('.repeat_on_occation').removeClass('required');
                 $('.repeat_on_occation').attr('disabled',true);
                 $('.repeat_on_occation').removeAttr('required');
             }else{
                $('.repeat_on_occation').addClass('required');
                $('.repeat_on_occation').removeAttr('disabled');
                $('.repeat_on_occation').attr('required',true);

                $('.repeat').removeClass('required');
                $('.repeat').attr('disabled',true); 
                $('.repeat').removeAttr('required');

             }
            })
    </script>
</body>
</html>

