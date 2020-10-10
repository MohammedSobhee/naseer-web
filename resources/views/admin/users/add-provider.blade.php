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
                <i class="fa fa-user-plus font-green-haze"></i>
                <span class="caption-subject font-green-haze bold uppercase">{{$title ?? ''}}</span>
            </div>
        </div>
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form class="form-horizontal" role="form" id="profile">
                {!! Form::open(['method'=>'post','class'=>'form-horizontal','files'=>true,'id'=>'formAdd']) !!}
                <input type="hidden" name="type" id="type" value="service_provider">
                <div class="form-body">
                    <h3 class="form-section">البيانات الاساسية</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-3">اسم كامل:</label>
                                <div class="col-md-9">
                                    <input type="text" name="name" id="name" class="form-control"
                                           placeholder="اضف الاسم كامل...">
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-3">رقم الهاتف:</label>
                                <div class="col-md-9">
                                    <input type="text" name="phone" id="phone" class="form-control"
                                           placeholder="اضف رقم الهاتف...">
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
                                    <input type="text" name="email" id="email" class="form-control"
                                           placeholder="اضف البريد الالكتروني...">
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-3">الجنس:</label>
                                <div class="col-md-9">
                                    <select class="form-control select" name="gender"
                                            id="gender">
                                        <option value="male">ذكر</option>
                                        <option value="female">انثى</option>
                                    </select>
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
                                    <select class="form-control select" name="city_id"
                                            id="city_id">
                                        @foreach($cities as $city)
                                            <option value="{{$city->id}}">{{$city->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-3">الحالة:</label>
                                <div class="col-md-9">
                                    <p class="form-control-static"><input type="checkbox"
                                                                          class="make-switch"
                                                                          data-on-text="&nbsp;مفعّل&nbsp;"
                                                                          data-off-text="&nbsp;معطّل&nbsp;"
                                                                          name="is_active"
                                                                          checked
                                                                          data-on-color="success"
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
                                <label class="control-label col-md-3">نوع مزود الخدمة:</label>
                                <div class="col-md-9">

                                    <select class="form-control select" name="service_provider_type_id"
                                            id="service_provider_type_id">
                                        @foreach($service_provider_types as $service_provider_type)
                                            <option
                                                value="{{$service_provider_type->id}}">{{$service_provider_type->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-3">العنوان:</label>
                                <div class="col-md-9">
                                    <textarea name="address" id="address" rows="5" placeholder="اضف العنوان"
                                              class="form-control"></textarea>
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
                                    <input type="text" name="idno" id="idno" class="form-control"
                                           placeholder="اضف رقم البطاقة الشخصية...">
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-3">صورة البطاقة التعريفية:</label>
                                <div class="col-md-9">
                                    <input type="file" name="idno_file" id="idno_file" class="form-control">
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
                                    <input type="text" name="skill" id="skill" class="form-control"
                                           placeholder="اضف الهواية...">
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-3">مرفق الهواية:</label>
                                <div class="col-md-9">
                                    <input type="file" name="skill_file" id="skill_file" class="form-control">

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

                                    <select class="form-control select" name="license_type"
                                            id="license_type">
                                        <option value="licensed">مرخص</option>
                                        <option value="unlicensed">غير مرخص</option>
                                    </select>

                                </div>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-3">ملف الرخصة:</label>
                                <div class="col-md-9">

                                    <input type="file" name="licensed_file" id="licensed_file" class="form-control">

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
                                    <textarea name="bio" id="bio" rows="5" placeholder="اضف نبذه..." class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                    </div>
                </div>

                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-circle green btn-md save"><i
                                    class="fa fa-user-plus"></i>
                                اضافة جديدة
                            </button>
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}
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
