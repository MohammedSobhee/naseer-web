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

                                <th width="10%"> الخدمة</th>
                                <th width="10%"> نوع مزود الخدمة</th>
                                <th width="10%"> العمليات</th>
                            </tr>
                            <tr role="row" class="filter">
                                <td></td>
                                <td>
                                    <input type="text" class="form-control form-filter input-md" name="name"
                                           placeholder=" الخدمة" id="name">
                                </td>

                                <td>
                                    <select class="form-control input-md service_provider_type_id select"
                                            name="service_provider_type_id"
                                            id="service_provider_type_id">
                                        <option value=""> نوع مزود الخدمة</option>
                                        @foreach($service_provider_types as $service_provider_type)
                                            <option value="{{$service_provider_type->id}}">{{$service_provider_type->name}}</option>
                                        @endforeach
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
                           id="services_tbl">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th> الخدمة</th>
                            <th> نوع مزود الخدمة</th>
                            <th>العمليات</th>
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
    =    <!-- BEGIN THEME GLOBAL SCRIPTS -->
    <script src="{{url('/')}}/assets/global/scripts/app.min.js" type="text/javascript"></script>
    <!-- END THEME GLOBAL SCRIPTS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <!-- END PAGE LEVEL SCRIPTS -->
    <script src="{{url('/')}}/assets/pages/scripts/components-select2.min.js" type="text/javascript"></script>
    <script src="{{url('/')}}/assets/js/services.js" type="text/javascript"></script>

@stop
