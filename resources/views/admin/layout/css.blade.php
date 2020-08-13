<!-- BEGIN GLOBAL MANDATORY STYLES -->
{{--<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />--}}
<link href="{{url('/')}}/assets/fonts/droid-arabic-kufi.css" rel="stylesheet" type="text/css"/>

<link href="{{url('/')}}/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="{{url('/')}}/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
<link href="{{url('/')}}/assets/global/plugins/bootstrap/css/bootstrap-rtl.min.css" rel="stylesheet" type="text/css" />
<link href="{{url('/')}}/assets/global/plugins/bootstrap-switch/css/bootstrap-switch-rtl.min.css" rel="stylesheet" type="text/css" />
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL PLUGINS -->

<link href="{{url('/')}}/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css"/>
<link href="{{url('/')}}/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet"
      type="text/css"/>
@yield('css')
<link href="{{url('/')}}/assets/global/plugins/bootstrap-toastr/toastr.min.css" rel="stylesheet" id="style_components"
      type="text/css">

<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL STYLES -->
<link href="{{url('/')}}/assets/global/css/components-md-rtl.min.css" rel="stylesheet" id="style_components" type="text/css" />
<link href="{{url('/')}}/assets/global/css/components-rounded-rtl.css" rel="stylesheet" id="style_components" type="text/css" />
<link href="{{url('/')}}/assets/global/css/plugins-md-rtl.min.css" rel="stylesheet" type="text/css" />
<!-- END THEME GLOBAL STYLES -->
<!-- BEGIN THEME LAYOUT STYLES -->
<link href="{{url('/')}}/assets/layouts/layout2/css/layout-rtl.min.css" rel="stylesheet" type="text/css" />
<link href="{{url('/')}}/assets/layouts/layout2/css/themes/blue-rtl.css" rel="stylesheet" type="text/css" id="style_color" />
<link href="{{url('/')}}/assets/layouts/layout2/css/custom-rtl.min.css" rel="stylesheet" type="text/css" />
<!-- END THEME LAYOUT STYLES -->
<link rel="shortcut icon" href="favicon.ico" />

<style>
    table th {
        text-align: center;
    }

    /*.fileinput-preview{*/
    /*    width: 100% !important;*/
    /*}*/

    table td{
        vertical-align: inherit !important;
    }


</style>
<style>
    .dataTables_wrapper .dataTables_processing {
        border: none !important;
        background: none !important;
        -webkit-box-shadow: none !important;
        -moz-box-shadow: none !important;
        box-shadow: none !important;
    }
    .modal-footer button {
        float:right;
        margin-left: 10px;
    }
    /*.select2-container {*/
    /*    width: 500px !important;*/
    /*}*/

    .select2-search__field{
        width: 613px !important;
    }
    th, td {
        text-align: center !important;
        vertical-align: inherit !important;
    }
</style>
@stack('css')
