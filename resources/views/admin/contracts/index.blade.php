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
                           id="contracts_tbl">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th> الخدمات</th>
                            <th> الحالة</th>
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
    <!-- BEGIN THEME GLOBAL SCRIPTS -->
    <script src="{{url('/')}}/assets/global/scripts/app.min.js" type="text/javascript"></script>
    <!-- END THEME GLOBAL SCRIPTS -->

    <script src="{{url('/')}}/assets/pages/scripts/table-datatables-managed.min.js"
            type="text/javascript"></script>
    <script src="{{url('/')}}/assets/js/contracts.js" type="text/javascript"></script>

@stop
