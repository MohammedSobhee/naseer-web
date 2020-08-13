@extends(admin_layout_vw().'.index')

@section('css')
    <link href="{{url('/')}}/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="{{url('/')}}/assets/global/plugins/morris/morris.css" rel="stylesheet" type="text/css"/>
    <link href="{{url('/')}}/assets/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{url('/')}}/assets/global/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css"/>

@endsection
@section('content')

    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="dashboard-stat2 ">
                <div class="display">
                    <div class="number">
                        <h3 class="font-green-sharp">
                            <span data-counter="counterup" data-value="{{$users_count ?? 0}}">0</span>
                        </h3>
                        <small>عدد المستخدمين</small>
                    </div>
                    <div class="icon">
                        <i class="icon-users"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="dashboard-stat2 ">
                <div class="display">
                    <div class="number">
                        <h3 class="font-blue-sharp">
                            <span data-counter="counterup" data-value="{{$service_providers_count ?? 0}}"></span>
                        </h3>
                        <small>عدد مزودي الخدمات</small>
                    </div>
                    <div class="icon">
                        <i class="icon-users"></i>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="dashboard-stat2 ">
                <div class="display">
                    <div class="number">
                        <h3 class="font-red-haze">
                            <span data-counter="counterup" data-value="{{$orders_new_count ?? 0}}">0</span>
                        </h3>
                        <small>عدد الطلبات جديدة</small>
                    </div>
                    <div class="icon">
                        <i class="icon-basket-loaded"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="dashboard-stat2 ">
                <div class="display">
                    <div class="number">
                        <h3 class="font-red-haze">
                            <span data-counter="counterup" data-value="{{$orders_completed_count ?? 0}}">0</span>
                        </h3>
                        <small>عدد الطلبات منتهية</small>
                    </div>
                    <div class="icon">
                        <i class="icon-basket-loaded"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <div class="clearfix"></div>
    <!-- END DASHBOARD STATS 1-->
{{--    <div class="row">--}}
{{--        <div class="col-lg-6 col-xs-12 col-sm-12">--}}
{{--            <!-- BEGIN PORTLET-->--}}
{{--            <div class="portlet light bordered">--}}
{{--                <div class="portlet-title">--}}
{{--                    <div class="caption">--}}
{{--                        <i class="icon-bar-chart font-dark hide"></i>--}}
{{--                        <span class="caption-subject font-dark bold uppercase">الطلبيات</span>--}}
{{--                        <span class="caption-helper">weekly stats...</span>--}}
{{--                    </div>--}}
{{--                    <div class="actions">--}}
{{--                        <div class="btn-group btn-group-devided" data-toggle="buttons">--}}
{{--                            <label class="btn red btn-outline btn-circle btn-sm active">--}}
{{--                                <input type="radio" name="options" class="toggle" id="option1">New</label>--}}
{{--                            <label class="btn red btn-outline btn-circle btn-sm">--}}
{{--                                <input type="radio" name="options" class="toggle" id="option2">Returning</label>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="portlet-body">--}}
{{--                    <div id="orders_loading">--}}
{{--                        <img src="{{url('/')}}/assets/global/img/loading.gif" alt="loading" /> </div>--}}
{{--                    <div id="orders_content" class="display-none">--}}
{{--                        <div id="orders" class="chart"> </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <!-- END PORTLET-->--}}
{{--        </div>--}}
{{--        <div class="col-lg-6 col-xs-12 col-sm-12">--}}
{{--            <!-- BEGIN PORTLET-->--}}
{{--            <div class="portlet light bordered">--}}
{{--                <div class="portlet-title">--}}
{{--                    <div class="caption">--}}
{{--                        <i class="icon-share font-red-sunglo hide"></i>--}}
{{--                        <span class="caption-subject font-dark bold uppercase">طلبات أسعار الاجهزة</span>--}}
{{--                        <span class="caption-helper">monthly stats...</span>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="portlet-body">--}}
{{--                    <div id="exchanges_loading">--}}
{{--                        <img src="{{url('/')}}/assets/global/img/loading.gif" alt="loading" /> </div>--}}
{{--                    <div id="exchanges_content" class="display-none">--}}
{{--                        <div id="exchanges" style="height: 300px;"> </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <!-- END PORTLET-->--}}
{{--        </div>--}}
{{--    </div>--}}
@endsection

@section('js')


    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="{{url('/')}}/assets/global/plugins/moment.min.js" type="text/javascript"></script>
    <script src="{{url('/')}}/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js"
            type="text/javascript"></script>
    <script src="{{url('/')}}/assets/global/plugins/morris/morris.min.js" type="text/javascript"></script>
    <script src="{{url('/')}}/assets/global/plugins/morris/raphael-min.js" type="text/javascript"></script>
    <script src="{{url('/')}}/assets/global/plugins/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
    <script src="{{url('/')}}/assets/global/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
    <script src="{{url('/')}}/assets/global/plugins/amcharts/amcharts/amcharts.js" type="text/javascript"></script>
    <script src="{{url('/')}}/assets/global/plugins/amcharts/amcharts/serial.js" type="text/javascript"></script>
    <script src="{{url('/')}}/assets/global/plugins/amcharts/amcharts/pie.js" type="text/javascript"></script>
    <script src="{{url('/')}}/assets/global/plugins/amcharts/amcharts/radar.js" type="text/javascript"></script>
    <script src="{{url('/')}}/assets/global/plugins/amcharts/amcharts/themes/light.js" type="text/javascript"></script>
    <script src="{{url('/')}}/assets/global/plugins/amcharts/amcharts/themes/patterns.js"
            type="text/javascript"></script>
    <script src="{{url('/')}}/assets/global/plugins/amcharts/amcharts/themes/chalk.js" type="text/javascript"></script>
    <script src="{{url('/')}}/assets/global/plugins/amcharts/ammap/ammap.js" type="text/javascript"></script>
    <script src="{{url('/')}}/assets/global/plugins/amcharts/ammap/maps/js/worldLow.js" type="text/javascript"></script>
    <script src="{{url('/')}}/assets/global/plugins/amcharts/amstockcharts/amstock.js" type="text/javascript"></script>
    <script src="{{url('/')}}/assets/global/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
    <script src="{{url('/')}}/assets/global/plugins/horizontal-timeline/horizontal-timeline.js"
            type="text/javascript"></script>
    <script src="{{url('/')}}/assets/global/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
    <script src="{{url('/')}}/assets/global/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
    <script src="{{url('/')}}/assets/global/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
    <script src="{{url('/')}}/assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js"
            type="text/javascript"></script>
    <script src="{{url('/')}}/assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
    <script src="{{url('/')}}/assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>
    <script src="{{url('/')}}/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js"
            type="text/javascript"></script>
    <script src="{{url('/')}}/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js"
            type="text/javascript"></script>
    <script src="{{url('/')}}/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js"
            type="text/javascript"></script>
    <script src="{{url('/')}}/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js"
            type="text/javascript"></script>
    <script src="{{url('/')}}/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js"
            type="text/javascript"></script>
    <script src="{{url('/')}}/assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js"
            type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL SCRIPTS -->
    <script src="{{url('/')}}/assets/global/scripts/app.min.js" type="text/javascript"></script>
    <!-- END THEME GLOBAL SCRIPTS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="{{url('/')}}/assets/pages/scripts/dashboard.min.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
@stop
