<link href="{{url('/')}}/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet"
      type="text/css"/>
<link href="{{url('/')}}/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css"/>
<link href="{{url('/')}}/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet"
      type="text/css"/>
<link href="{{url('/')}}/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet"
      type="text/css"/>
<link href="{{url('/')}}/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet"
      type="text/css"/>
<link href="{{url('/')}}/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css"
      rel="stylesheet" type="text/css"/>
<style>
    .datepicker {
        width: fit-content !important;
    }
</style>
<div class="modal fade bs-modal-lg" id="user_view_frm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"><i class="fa fa-exchange"></i> تفاصيل المستخدم<span
                            class="badge badge-primary name "
                            style="text-transform: inherit"></span></h4>
            </div>
            <div class="modal-body">
                <div class="portlet-body form">

                    {!! Form::open(['method'=>'POST','class'=>'form-horizontal form-bordered form-row-stripped']) !!}


                    <div class="form-body">
                        <div class="form-group ">
                            <label class="control-label col-md-3">الصورة</label>
                            <div class="col-md-9">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-preview thumbnail" data-trigger="fileinput"
                                         style="width: 200px; height: 200px;">
                                        @if(isset($user->logo))
                                            <img src="{{$user->logo}}" style="max-height: none !important;">

                                        @else
                                            <img src="{{url('assets/man.svg')}}" alt="No Image"/>

                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="form-group">
                            <div class="control-label col-md-2">
                                <label for="driver_types">اسم المستخدم</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="name" id="name" class="form-control"
                                       value="{{$user->name}}" disabled>
                            </div>
                            <div class="control-label col-md-2">
                                <label for="email">البريد الالكتروني</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="email" id="email" class="form-control"
                                       value="{{$user->email}}" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="control-label col-md-2">
                                <label for="is_active">حالته</label>
                            </div>
                            <div class="control-label col-md-4">
                                <input type="text" name="is_active" id="is_active" class="form-control"
                                       value="{{($user->is_active)? 'مفعّل':'معطّل'}}" disabled>
                            </div>
                            <div class="control-label col-md-2">
                                <label for="mobile">رقم الهاتف</label>
                            </div>
                            <div class="control-label col-md-4">
                                <input type="text" name="mobile" id="mobile" class="form-control"
                                       value="{{$user->mobile}}" disabled>
                            </div>

                        </div>

                    </div>

                    <div class="form-body">

                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <button type="button" class="btn btn-circle btn-md red"
                                            data-dismiss="modal">
                                        <i class="fa fa-times"></i>
                                        اغلاق
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
<script src="{{url('/')}}/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<script src="{{url('/')}}/assets/pages/scripts/components-select2.min.js" type="text/javascript"></script>

<script src="{{url('/')}}/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"
        type="text/javascript"></script>
<script src="{{url('/')}}/assets/global/plugins/moment.min.js" type="text/javascript"></script>
<script src="{{url('/')}}/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js"
        type="text/javascript"></script>

<script src="{{url('/')}}/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"
        type="text/javascript"></script>
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="{{url('/')}}/assets/global/scripts/app.min.js" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{url('/')}}/assets/pages/scripts/components-date-time-pickers.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->