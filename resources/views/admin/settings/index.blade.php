@extends(admin_layout_vw().'.index')

@section('css')
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">

            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="fa fa-cog font-dark"></i>
                        <span class="caption-subject bold uppercase"> الاعدادات</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    {{--<form class="form-horizontal" role="form">--}}
                    {!! Form::open(['method'=>'PUT','class'=>'form-horizontal','files'=>true,'id'=>'formEdit']) !!}

                    <div class="form-group">
                        <label for="support_mobile" class="col-md-2 control-label">وقت انتهاء صلاحية الطلب</label>
                        <div class="col-md-6">
                            <div class="input-group">

                                <input type="text" class="form-control " value="{{$setting->expire_offer ?? ''}}"
                                       name="expire_offer" id="expire_offer" placeholder="وقت انتهاء صلاحية الطلب">
                                <span class="input-group-addon">
                                                        ساعة
                                                    </span>
                            </div>
                        </div>
                    </div>
                    {{--                    <div class="form-group">--}}
                    {{--                        <label for="contract" class="col-md-2 control-label">تفاصيل عقد الاتفاق</label>--}}
                    {{--                        <div class="col-md-6">--}}
                    {{--                            <textarea rows="5" class="form-control ckeditor" name="contract"--}}
                    {{--                                      placeholder="تفاصيل عقد الاتفاق">{{$setting->contract ?? ''}}--}}
                    {{--                            </textarea>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}

                    <div class="form-group">
                        <label for="terms" class="col-md-2 control-label">الشروط والاحكام</label>
                        <div class="col-md-6">
                            <textarea rows="3" class="form-control ckeditor" name="terms" id="terms"
                                      placeholder="الشروط والاحكام">{{$setting->terms ?? ''}}
                            </textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="terms" class="col-md-2 control-label">عن التطبيق</label>
                        <div class="col-md-6">
                            <textarea rows="3" class="form-control ckeditor" name="about_app" id="about_app"
                                      placeholder="عن التطبيق">{{$setting->about_app ?? ''}}
                            </textarea>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-circle green btn-md save"><i
                                        class="fa fa-check"></i>
                                    حفظ
                                </button>
                            </div>
                        </div>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
@endsection

@section('js')

    <!-- BEGIN THEME GLOBAL SCRIPTS -->
    <script src="{{url('/')}}/assets/global/scripts/app.min.js" type="text/javascript"></script>
    <!-- END THEME GLOBAL SCRIPTS -->

    <script src="{{url('/')}}/assets/js/setting.js" type="text/javascript"></script>
    <script src="{{url('/')}}/assets/global/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>

@stop
