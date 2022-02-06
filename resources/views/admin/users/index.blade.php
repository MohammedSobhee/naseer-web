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
                        {!! Form::open(['method'=>'POST','url'=>url(admin_users_url().'/export')]) !!}
                        {{--                        <form method="POST" action="#">--}}
                        <input type="hidden" class="form-control form-filter input-md" name="type" value="user">
                        <table class="table table-striped table-bordered table-hover table-checkable"
                               id="datatable_products">
                            <thead>
                            <tr role="row" class="heading">
                                <th width="1%">
                                </th>

                                <th width="10%"> اسم المستخدم</th>
                                <th width="20%"> البريد الالكتروني</th>
                                <th width="10%"> رقم الهاتف</th>
                                <th width="10%"> حالة التحقق</th>
                                <th width="10%"> الحالة</th>
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
                                    <input type="text" class="form-control form-filter input-md" name="phone"
                                           placeholder="رقم الهاتف" id="phone">
                                </td>
                                <td>
                                    <select class="form-control input-md is_verify select" name="is_verify"
                                            id="is_verify">
                                        <option value="">اختيار حالة التحقق</option>
                                        <option value="1">مفعّل</option>
                                        <option value="0">معطّل</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control input-md is_active select" name="is_active"
                                            id="is_active">
                                        <option value="">اختيار الحالة</option>
                                        <option value="1">مفعّل</option>
                                        <option value="0">معطّل</option>
                                    </select>
                                </td>

                                <td>
                                    <div class="margin-bottom-5">
                                        <a href="javascript:;"
                                           class="btn btn-sm btn-success filter-submit btn-circle btn-icon-only margin-bottom"
                                           title="فلترة">
                                            <i class="fa fa-search"></i>
                                        </a>
                                        <button type="submit"
                                                class="btn btn-sm btn-default btn-circle btn-icon-only"
                                                title="تصدير">
                                            <i class="fa fa-file-excel-o"></i>
                                        </button>
                                        <a href="javascript:;"
                                           class="btn btn-sm btn-danger btn-circle btn-icon-only filter-cancel"
                                           title="افراغ الخانات">
                                            <i class="fa fa-rotate-left"></i>
                                        </a>
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
                            <th> الجنس</th>
                            <th> البريد الالكتروني</th>
                            {{--                            <th> تحقق البريد الالكتروني</th>--}}
                            <th> رقم الهاتف</th>
                            <th> تحقق الهاتف</th>
                            <th>المدينة</th>
                            <th> الحالة</th>
                            <th> الاعتمادية</th>
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
    <script src="{{url('/')}}/assets/js/users.js" type="text/javascript"></script>

@stop
