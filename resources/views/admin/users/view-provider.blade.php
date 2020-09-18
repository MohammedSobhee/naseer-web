@extends(admin_layout_vw().'.index')

@section('css')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="{{url('/')}}/assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{url('/')}}/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap-rtl.css"
          rel="stylesheet" type="text/css"/>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="{{url('/')}}/assets/global/css/components-md-rtl.min.css" rel="stylesheet" id="style_components"
          type="text/css"/>
    <link href="{{url('/')}}/assets/global/css/plugins-md-rtl.min.css" rel="stylesheet" type="text/css"/>
    <!-- END THEME GLOBAL STYLES -->
@endsection
@section('content')

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-equalizer font-green-haze"></i>
                <span class="caption-subject font-green-haze bold uppercase">البيانات الشخصية</span>
                <span class="caption-helper">مزود خدمة...</span>
            </div>
            <div class="actions">
                <a class="btn btn-circle btn-primary" href="javascript:;">
                    <i class="icon-eye"></i>
                    عرض التعديلات
                </a>
                <a class="btn btn-circle btn-danger" href="javascript:;">
                    <i class="icon-check"></i>
                    اعتماد التعديلات
                </a>
            </div>
        </div>
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form class="form-horizontal" role="form" id="profile">
                <div class="form-body">
                    <h3 class="form-section">البيانات الاساسية</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-3">اسم المستخدم:</label>
                                <div class="col-md-9">
                                    <p class="form-control-static"> {{$user->name ?? ''}} </p>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-3">رقم الهاتف:</label>
                                <div class="col-md-9">
                                    <p class="form-control-static">  {{$user->country_code.$user->phone ?? ''}}  </p>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                    </div>
                    <!--/row-->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-3">البريد الالكتروني:</label>
                                <div class="col-md-9">
                                    <p class="form-control-static">  {{$user->email ?? ''}}  </p>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-3">الجنس:</label>
                                <div class="col-md-9">
                                    <p class="form-control-static">  {{$user->gender == 'male' ? 'ذكر' : 'انثى' ?? 'غير محدد'}}  </p>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                    </div>
                    <!--/row-->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-3">المدينة:</label>
                                <div class="col-md-9">
                                    <p class="form-control-static">  {{$user->city->name ?? ''}}  </p>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-3">الحالة:</label>
                                <div class="col-md-9">
                                    <p class="form-control-static"><input type="checkbox"
                                                                          class="make-switch change_activation"
                                                                          data-on-text="&nbsp;مفعّل&nbsp;"
                                                                          data-off-text="&nbsp;معطّل&nbsp;"
                                                                          name="is_active" data-id="{{$user->id}}"
                                                                          @if($user->is_active) checked
                                                                          @endif data-on-color="success"
                                                                          data-size="mini" data-off-color="warning"></p>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                    </div>
                    <!--/row-->
                    <h3 class="form-section">البيانات الفرعية</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-3">نوع مقدم الخدمة:</label>
                                <div class="col-md-9">
                                    <p class="form-control-static">  {{$user->ServiceProvider->ServiceProviderType->name ?? ''}}  </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-3">العنوان:</label>
                                <div class="col-md-9">
                                    <p class="form-control-static">  {{$user->ServiceProvider->address ?? ''}}  </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/row-->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-3">رقم البطاقة الشخصية:</label>
                                <div class="col-md-9">
                                    <p class="form-control-static">  {{$user->ServiceProvider->idno ?? ''}}  </p>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-3">صورة البطاقة التعريفية:</label>
                                <div class="col-md-9">
                                    <p class="form-control-static">  @if(isset($user->ServiceProvider->idno_file))<a
                                            href="{{$user->ServiceProvider->idno_file ?? '#'}}" target="_blank">ملف
                                            البطاقة التعريفية</a> @else غير مُرفقة @endif </p>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-3">الهواية:</label>
                                <div class="col-md-9">
                                    <p class="form-control-static"> {{$user->ServiceProvider->skill ?? ''}} </p>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-3">مرفق الهواية:</label>
                                <div class="col-md-9">
                                    <p class="form-control-static"> @if(isset($user->ServiceProvider->skill_file))<a
                                            href="{{$user->ServiceProvider->skill_file ?? '#'}}" target="_blank">مرفق
                                            الهواية</a> @else غير مُرفقة @endif </p>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-3">حالة الرخصة:</label>
                                <div class="col-md-9">
                                    <p class="form-control-static">  {{$user->ServiceProvider->license_type == 'licensed' ? 'مرخص' : 'غير مرخص' ?? ''}}  </p>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-3">ملف الرخصة:</label>
                                <div class="col-md-9">
                                    <p class="form-control-static"> @if(isset($user->ServiceProvider->licensed_file)) <a
                                            href="{{$user->ServiceProvider->licensed_file ?? '#'}}" target="_blank">مرفق
                                            الهواية</a> @else غير مُرفقة @endif  </p>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-3">نبذه:</label>
                                <div class="col-md-9">
                                    <p class="form-control-static">  {{$user->ServiceProvider->bio ?? ''}}  </p>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                    </div>
                </div>
            </form>
            <!-- END FORM-->
        </div>
    </div>

@endsection
@section('js')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="{{url('/')}}/assets/global/scripts/datatable.js" type="text/javascript"></script>
    <script src="{{url('/')}}/assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
    <script src="{{url('/')}}/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js"
            type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    =    <!-- BEGIN THEME GLOBAL SCRIPTS -->
    <script src="{{url('/')}}/assets/global/scripts/app.min.js" type="text/javascript"></script>
    <!-- END THEME GLOBAL SCRIPTS -->
    <script src="{{url('/')}}/assets/pages/scripts/form-samples.min.js" type="text/javascript"></script>

    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <!-- END PAGE LEVEL SCRIPTS -->
    <script src="{{url('/')}}/assets/pages/scripts/components-select2.min.js" type="text/javascript"></script>
    <script src="{{url('/')}}/assets/js/providers.js" type="text/javascript"></script>

@stop
