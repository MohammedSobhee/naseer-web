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
                        <span class="caption-subject bold uppercase"> الاعدادات</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    {{--<form class="form-horizontal" role="form">--}}
                    {!! Form::open(['method'=>'POST','class'=>'form-horizontal','files'=>true,'id'=>'formEdit']) !!}


                    <div class="caption font-dark" style="margin: 40px 0px 20px 0px;">
                        <i class="fa fa-support font-dark"></i>
                        <span class="caption-subject bold uppercase"> Support data</span>
                    </div>
                    <div class="form-group">
                        <label for="support_email" class="col-md-2 control-label">Email</label>
                        <div class="col-md-6">
                            <input type="email" value="{{$setting->support_email ?? ''}}" class="form-control" name="support_email" id="support_email" placeholder="Email">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="support_phone" class="col-md-2 control-label">Phone</label>
                        <div class="col-md-6">
                            <input type="text" value="{{$setting->support_phone ?? ''}}" class="form-control" name="support_phone" id="support_phone" placeholder="Phone">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="support_mobile" class="col-md-2 control-label">Mobile</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" value="{{$setting->support_mobile ?? ''}}" name="support_mobile" id="support_mobile" placeholder="Mobile">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="support_address" class="col-md-2 control-label">Address</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" value="{{$setting->support_address ?? ''}}" name="support_address" id="support_address"
                                   placeholder="Address">
                        </div>
                    </div>

                    <div class="caption font-dark" style="margin: 40px 0px 20px 0px;">
                        <i class="fa fa-file-text font-dark"></i>
                        <span class="caption-subject bold uppercase"> Landing Page Contents </span>
                    </div>

                    <div class="form-group">
                        <label for="commercial_content" class="col-md-2 control-label">Commercial Content</label>
                        <div class="col-md-6">
                            <textarea rows="4"  class="form-control" name="commercial_content"
                                  >{{$setting->commercial_content ?? ''}}
                            </textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="services_content" class="col-md-2 control-label">Services Content</label>
                        <div class="col-md-6">
                            <textarea rows="4"  class="form-control" name="services_content" id="services_content"
                                   placeholder="Services Content"> {{$setting->services_content ?? ''}}
                            </textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="steps_content" class="col-md-2 control-label">Steps Content</label>
                        <div class="col-md-6">
                            <textarea rows="4"  class="form-control"  name="steps_content" id="steps_content"
                                   placeholder="Steps Content">{{$setting->steps_content ?? ''}}
                            </textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="how_to_content" class="col-md-2 control-label">How to Content</label>
                        <div class="col-md-6">
                            <textarea rows="4"  class="form-control" name="how_to_content" id="how_to_content"
                                   placeholder="How to Content">{{$setting->how_to_content ?? ''}}
                            </textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="packages_content" class="col-md-2 control-label">Packages Content</label>
                        <div class="col-md-6">
                            <textarea rows="4"  class="form-control" name="packages_content" id="packages_content"
                                   placeholder="Packages Content">{{$setting->packages_content ?? ''}}
                            </textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="screen_shots_content" class="col-md-2 control-label">Screen Shots Content</label>
                        <div class="col-md-6">
                            <textarea  rows="4" class="form-control"  name="screen_shots_content" id="screen_shots_content"
                                   placeholder="Screen Shots Content">{{$setting->screen_shots_content ?? ''}}
                            </textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="sales_content" class="col-md-2 control-label">Sales Content</label>
                        <div class="col-md-6">
                            <textarea  rows="4" class="form-control" name="sales_content" id="sales_content"
                                   placeholder="Sales Content"> {{$setting->sales_content ?? ''}}
                            </textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="success_content" class="col-md-2 control-label">Success Content</label>
                        <div class="col-md-6">
                            <textarea  rows="4"  class="form-control"  name="success_content" id="success_content"
                                   placeholder="Success Content">{{$setting->success_content ?? ''}}
                            </textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="blogs_content" class="col-md-2 control-label">Blogs Content</label>
                        <div class="col-md-6">
                            <textarea  rows="4" class="form-control" name="blogs_content"  id="blogs_content"
                                   placeholder="Blogs Content">{{$setting->blogs_content ?? ''}}
                            </textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="vedios_content" class="col-md-2 control-label">Videos Content</label>
                        <div class="col-md-6">
                            <textarea  rows="4" class="form-control" name="vedios_content"  id="vedios_content"
                                   placeholder="Videos Content">{{$setting->vedios_content ?? ''}}
                            </textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="vedios_content" class="col-md-2 control-label">Additional Videos Content</label>
                        <div class="col-md-6">
                            <textarea rows="4" class="form-control" name="additional_video_content" id="additional_video_content"
                                      placeholder="Videos Content">{{$setting->additional_video_content ?? ''}}
                            </textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="contact_us_content" class="col-md-2 control-label">Contact Us Content</label>
                        <div class="col-md-6">
                            <textarea  rows="4" class="form-control" name="contact_us_content"  id="contact_us_content"
                                   placeholder="Contact Us Content">{{$setting->contact_us_content ?? ''}}
                            </textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-8 text-center">
                            <button type="submit" class="btn green save"> Save<i class="fa fa-save"></i></button>
                        </div>
                    </div>

                    {!! Form::close() !!}
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

    <script src="{{url('/')}}/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"
            type="text/javascript"></script>


    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL SCRIPTS -->
    <script src="{{url('/')}}/assets/global/scripts/app.min.js" type="text/javascript"></script>
    <!-- END THEME GLOBAL SCRIPTS -->

    <script src="{{url('/')}}/assets/pages/scripts/table-datatables-managed.min.js"
            type="text/javascript"></script>
    <script src="{{url('/')}}/assets/js/setting.js" type="text/javascript"></script>

@stop
