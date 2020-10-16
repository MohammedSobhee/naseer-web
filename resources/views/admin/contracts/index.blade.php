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
                    <div class="actions">
                        <a href="{{url(admin_vw().'/contracts/add-contract')}}"
                           class="btn btn-circle btn-info">
                            <i class="fa fa-file"></i>
                            <span class="hidden-xs"> اضافة </span>
                        </a>
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
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL SCRIPTS -->
    <script src="{{url('/')}}/assets/global/scripts/app.min.js" type="text/javascript"></script>
    <!-- END THEME GLOBAL SCRIPTS -->

    <script src="{{url('/')}}/assets/pages/scripts/table-datatables-managed.min.js"
            type="text/javascript"></script>
    <script src="{{url('/')}}/assets/js/contracts.js" type="text/javascript"></script>

@stop
