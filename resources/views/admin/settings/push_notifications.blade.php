@extends(admin_layout_vw().'.index')

@section('css')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="{{url('/')}}/assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{url('/')}}/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css"
          rel="stylesheet" type="text/css"/>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="{{url('/')}}/assets/global/css/components-md.min.css" rel="stylesheet" id="style_components"
          type="text/css"/>
    <link href="{{url('/')}}/assets/global/css/plugins-md.min.css" rel="stylesheet" type="text/css"/>
    <!-- END THEME GLOBAL STYLES -->
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet box grey-gallery ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="{{$icon}}"></i>
                        <span class="caption-subject bold uppercase"> {{$main_title}}</span>
                    </div>
                    <div class="actions">
                        <a href="javascript:;" class="btn btn-circle btn-info add-send-notification-mdl">
                            <i class="fa fa-send"></i>
                            <span class="hidden-xs"> Send Public Notification. </span>
                        </a>
                    </div>

                </div>
                <div class="portlet-body">

                    <table class="table table-striped table-bordered table-hover table-checkable order-column"
                           id="notification_tbl">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th> Sender</th>
                            <th> Notification</th>
                            <th> Date</th>
                            <th> Action</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>

    <div class="modal fade bs-modal-lg" id="general-notification" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title"><i class="fa fa-send"></i> Send public notification<span
                            class="badge badge-primary name "
                            style="text-transform: inherit"></span></h4>
                </div>
                <div class="modal-body">
                    <div class="portlet-body form">

                        {!! Form::open(['method' => 'POST', 'class' => 'form-horizontal form-bordered form-row-stripped', 'url' => url(admin_vw() . '/general-notification/create'), 'files' => true, 'id' => 'generalNotificationFrm']) !!}

                        <div class="alert alert-danger" style="display: none">

                        </div>
                        <div class="form-body">

                            <div class="form-group">
                                <div class="control-label col-md-2">
                                    <label for="message">Message</label>
                                </div>
                                <div class="control-label col-md-10">
                                <textarea name="message" id="message" class="form-control" rows="5"
                                          placeholder="Message ..."></textarea>
                                </div>

                            </div>
                        </div>

                        <div class="form-body">

                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-circle green btn-md save"><i
                                                class="fa fa-check"></i>
                                            Send
                                        </button>
                                        <button type="button" class="btn btn-circle btn-md red"
                                                data-dismiss="modal">
                                            <i class="fa fa-times"></i>
                                            Close
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {!! Form::close() !!}


                    </div>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
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
    <script src="{{url('/')}}/assets/js/notifications.js" type="text/javascript"></script>

@stop
