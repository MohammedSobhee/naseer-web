@extends(admin_layout_vw().'.index')

@section('css')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="{{url('/')}}/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet"
          type="text/css"/>
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="{{url('/')}}/assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{url('/')}}/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css"
          rel="stylesheet" type="text/css"/>


    <link href="{{url('/')}}/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{url('/')}}/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet"
          type="text/css"/>
    <!-- END PAGE LEVEL PLUGINS -->

@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">

            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="fa fa-cog font-dark"></i>
                        <span class="caption-subject bold uppercase"> العقود</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    {{--<form class="form-horizontal" role="form">--}}
                    {!! Form::open(['method'=>'POST','class'=>'form-horizontal','files'=>true,'id'=>'formAdd']) !!}

                    <div class="form-group">
                        <label for="services" class="col-md-2 control-label">الخدمات</label>
                        <div class="col-md-6">
                            <select class="form-control select2" multiple name="service_ids[]" id="service_ids"
                                    data-placeholder="أنواع الخدمات">
                                @foreach($services as $service)
                                    <option value="{{$service->id}}">{{$service->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="contract" class="col-md-2 control-label">تفاصيل عقد الاتفاق</label>
                        <div class="col-md-6">
                            <textarea rows="5" class="form-control ckeditor" name="text"
                                      placeholder="تفاصيل عقد الاتفاق">
                            </textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="mt-repeater form-horizontal">
                            <h3 class="mt-repeater-title">Human Resource Management</h3>
                            <div data-repeater-list="group-a">
                                <div data-repeater-item class="mt-repeater-item">
                                    <!-- jQuery Repeater Container -->
                                    <div class="mt-repeater-input">
                                        <label class="control-label">Name</label>
                                        <br/>
                                        <input type="text" name="text-input" class="form-control" value="John Smith"/>
                                    </div>
                                    <div class="mt-repeater-input">
                                        <label class="control-label">Joined Date</label>
                                        <br/>
                                        <input class="input-group form-control form-control-inline date date-picker"
                                               size="16" type="text" value="01/08/2016" name="date-input"
                                               data-date-format="dd/mm/yyyy"/></div>
                                    <div class="mt-repeater-input mt-repeater-textarea">
                                        <label class="control-label">Job Description</label>
                                        <br/>
                                        <textarea name="textarea-input" class="form-control" rows="3">This role is to follow up with all meetings and ensure that each operational process flow moves accordingly in a timely manner.</textarea>
                                    </div>
                                    <div class="mt-repeater-input mt-radio-inline">
                                        <label class="control-label">Tier</label>
                                        <br/>
                                        <label class="mt-radio">
                                            <input type="radio" name="optionsRadios" id="optionsRadios25" value="junior"
                                                   checked=""> Junior
                                            <span></span>
                                        </label>
                                        <label class="mt-radio">
                                            <input type="radio" name="optionsRadios" id="optionsRadios26" value="senior"
                                                   checked=""> Senior
                                            <span></span>
                                        </label>
                                    </div>
                                    <div class="mt-repeater-input mt-checkbox-inline">
                                        <label class="control-label">Language</label>
                                        <br/>
                                        <label class="mt-checkbox">
                                            <input type="checkbox" id="inlineCheckbox21" value="option1"> English
                                            <span></span>
                                        </label>
                                        <label class="mt-checkbox">
                                            <input type="checkbox" id="inlineCheckbox22" value="option2"> French
                                            <span></span>
                                        </label>
                                    </div>
                                    <div class="mt-repeater-input">
                                        <label class="control-label">Department</label>
                                        <br/>
                                        <select name="select-input" class="form-control">
                                            <option value="A" selected>Marketing</option>
                                            <option value="B">Creative</option>
                                            <option value="C">Development</option>
                                        </select>
                                    </div>
                                    <div class="mt-repeater-input">
                                        <a href="javascript:;" data-repeater-delete
                                           class="btn btn-danger mt-repeater-delete">
                                            <i class="fa fa-close"></i> Delete</a>
                                    </div>
                                </div>
                            </div>
                            <a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-add">
                                <i class="fa fa-plus"></i> Add</a>
                        </div>
                    </div>


                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-circle green btn-md save"><i
                                        class="fa fa-check"></i>
                                    اضافة
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
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="fa fa-search font-dark"></i>
                        <span class="caption-subject bold uppercase"> بحث </span>
                    </div>

                </div>
                <div class="portlet-body">
                    <div class="table-container">
                        {!! Form::open(['method'=>'POST','url'=>url(admin_vw().'/admins/export')]) !!}
                        <table class="table table-striped table-bordered table-hover table-checkable"
                               id="datatable_products">
                            <thead>
                            <tr role="row" class="heading">
                                <th width="1%">
                                </th>

                                <th width="10%"> مقدم الطلب</th>
                                <th width="10%"> المدينة</th>
                                <th width="10%"> نوع الخدمة</th>
                                <th width="10%"> الخدمة</th>
                                <th width="10%"> حالة الطلب</th>
                                <th width="10%"> العمليات</th>
                            </tr>
                            <tr role="row" class="filter">
                                <td></td>
                                <td>
                                    <input type="text" class="form-control form-filter input-md" name="name"
                                           placeholder=" مقدم الطلب" id="name">
                                </td>
                                <td>
                                    <input type="text" class="form-control form-filter input-md" name="city"
                                           placeholder="المدينة" id="city">
                                </td>
                                <td>
                                    <select class="form-control input-md type select"
                                            name="type"
                                            id="type">
                                        <option value="">نوع الخدمة</option>
                                        <option value="categorized">مصنّفة</option>
                                        <option value="uncategorized">غير مصنّفة</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control input-md service_id select"
                                            name="service_id"
                                            id="service_id">
                                        <option value=""> الخدمة</option>
                                        {{--                                        @foreach($services as $service)--}}
                                        {{--                                            <option value="{{$service->id}}">{{$service->name}}</option>--}}
                                        {{--                                        @endforeach--}}
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control input-md status select"
                                            name="status"
                                            id="status">
                                        <option value="">حالة الطلب</option>
                                        <option value="new">جديدة</option>
                                        <option value="completed">منتهية</option>
                                        <option value="canceled">ملغاة</option>
                                    </select>
                                </td>
                                <td>
                                    <div class="margin-bottom-5">
                                        <a href="javascript:;"
                                           class="btn btn-sm btn-success filter-submit btn-circle btn-icon-only margin-bottom"
                                           title="فلترة">
                                            <i class="fa fa-search"></i>
                                        </a>
                                        <a href="javascript:;"
                                           class="btn btn-sm btn-danger btn-circle btn-icon-only filter-cancel"
                                           title="افراغ الخانات">
                                            <i class="fa fa-rotate-left"></i>
                                        </a>


                                        {{--                                        <button type="submit"--}}
                                        {{--                                                class="btn btn-sm btn-default btn-circle btn-icon-only filter-export margin-bottom" title="تصدير اكسل">--}}
                                        {{--                                            <i class="fa fa-file-excel-o"></i>--}}
                                        {{--                                        </button>--}}

                                    </div>

                                </td>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="{{$icon}} font-dark"></i>
                        <span class="caption-subject bold uppercase"> {{$title}}</span>
                    </div>

                </div>
                <div class="portlet-body">

                    <table class="table table-striped table-bordered table-hover table-checkable order-column"
                           id="rates_tbl">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th> مقدم الطلب</th>
                            <th> مزود الخدمة</th>
                            <th> نوع الخدمة</th>
                            <th> الخدمة</th>
                            <th> التقييم</th>
                            <th> نص التقييم</th>
                            <th>الاعتماد</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>

@endsection

@section('js')

    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="{{url('/')}}/assets/global/scripts/datatable.js" type="text/javascript"></script>
    <script src="{{url('/')}}/assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
    <script src="{{url('/')}}/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js"
            type="text/javascript"></script>


    <script src="{{url('/')}}/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>

    <script src="{{url('/')}}/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"
            type="text/javascript"></script>

    <script src="{{url('/')}}/assets/global/plugins/jquery-repeater/jquery.repeater.js" type="text/javascript"></script>


    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL SCRIPTS -->
    <script src="{{url('/')}}/assets/global/scripts/app.min.js" type="text/javascript"></script>
    <!-- END THEME GLOBAL SCRIPTS -->
    <script src="{{url('/')}}/assets/pages/scripts/form-repeater.min.js" type="text/javascript"></script>
    <script src="{{url('/')}}/assets/pages/scripts/components-select2.min.js" type="text/javascript"></script>


    <script src="{{url('/')}}/assets/pages/scripts/table-datatables-managed.min.js"
            type="text/javascript"></script>
    <script src="{{url('/')}}/assets/js/contracts.js" type="text/javascript"></script>
    <script src="{{url('/')}}/assets/global/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>

@stop
