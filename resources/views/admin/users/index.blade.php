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

    <style>
        td {
            direction: ltr !important;
        }
    </style>
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
                        {!! Form::open(['method'=>'POST','url'=>url(admin_vw().'/users/export')]) !!}
                        {{--                        <form method="POST" action="#">--}}
                        <table class="table table-striped table-bordered table-hover table-checkable"
                               id="datatable_products">
                            <thead>
                            <tr role="row" class="heading">
                                <th width="1%">
                                </th>

                                <th width="10%"> اسم المستخدم</th>
                                <th width="20%"> البريد الالكتروني</th>
                                <th width="10%"> تحقق البريد الالكتروني</th>
                                <th width="10%"> رقم الهاتف</th>
                                <th width="10%"> تأكيد المدير</th>
                                <th width="10%"> العمليات</th>
                            </tr>
                            <tr role="row" class="filter">
                                <td></td>
                                <td>
                                    <input type="text" class="form-control form-filter input-md" name="name"
                                           placeholder=" اسم المستخدم" id="name">
                                </td>
                                <td>
                                    <input type="email" class="form-control form-filter input-md" name="email"
                                           placeholder="البريد الالكتروني" id="email">
                                </td>

                                <td>
                                    <select class="form-control input-md email_verified_at select"
                                            name="email_verified_at"
                                            id="email_verified_at">
                                        <option value="">اختيار حالة البريد الالكتروني</option>
                                        <option value="0">{{trans('app.unverified')}}</option>
                                        <option value="1">{{trans('app.verified')}}</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" class="form-control form-filter input-md" name="mobile"
                                           placeholder="رقم الهاتف" id="mobile">
                                </td>
                                <td>
                                    <select class="form-control input-md is_active select" name="is_active"
                                            id="is_active">
                                        <option value="">اختيار تأكيد المدير</option>
                                        <option value="0">{{trans('app.deactivate')}}</option>
                                        <option value="1">{{trans('app.activate')}}</option>
                                    </select>
                                </td>

                                <td>
                                    <div class="margin-bottom-5">
                                        <a href="javascript:;"
                                           class="btn btn-sm btn-danger btn-circle btn-icon-only filter-cancel"
                                           title="افراغ الخانات">
                                            <i class="fa fa-rotate-left"></i>
                                        </a>
                                        <a href="javascript:;"
                                           class="btn btn-sm btn-success filter-submit btn-circle btn-icon-only margin-bottom"
                                           title="فلترة">
                                            <i class="fa fa-search"></i>
                                        </a>

                                        <button type="submit"
                                                class="btn btn-sm btn-default btn-circle btn-icon-only filter-export margin-bottom"
                                                title="تصدير اكسل">
                                            <i class="fa fa-file-excel-o"></i>
                                        </button>


                                    </div>

                                </td>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        {!! Form::close() !!}
                        {{--                        </form>--}}
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
                           id="users_tbl">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th> الصورة</th>
                            <th> اسم المستخدم</th>
                            <th> البريد الالكتروني</th>
                            <th> التحقق البريد الالكتروني</th>
                            <th> رقم الهاتف</th>
                            <th>تأكيد المدير</th>
                            <th>تفاصيل</th>
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
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="{{url('/')}}/assets/pages/scripts/table-datatables-managed.min.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
    <script src="{{url('/')}}/assets/js/users.js" type="text/javascript"></script>

@stop