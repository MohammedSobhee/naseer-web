<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" dir="rtl">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8"/>
    <title>نصير | {{$title ?? 'الصفحة الرئيسية'}}</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta content="Preview page of Metronic Admin RTL Theme #2 for statistics, charts, recent events and reports"
          name="description"/>
    <meta content="{{csrf_token()}}" name="csrf-token">
    <meta content="" name="author"/>

    @include(admin_layout_vw().'.css')

</head>
<!-- END HEAD -->

<body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-md">
<!-- BEGIN HEADER -->
@include(admin_layout_vw().'.header')
<!-- END HEADER -->
<!-- BEGIN HEADER & CONTENT DIVIDER -->
<div class="clearfix"></div>
<!-- END HEADER & CONTENT DIVIDER -->
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
@include(admin_layout_vw().'.sidebar')

<!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            @include(admin_layout_vw().'.breadcrumb')
            <div class="alert alert-danger" role="alert" style="display: none"></div>
            @yield('content')
        </div>
        <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->

<div id="results-modals"></div>

<!-- BEGIN FOOTER -->
@include(admin_layout_vw().'.footer')
<!-- END FOOTER -->
@include(admin_layout_vw().'.js')


</body>

</html>
