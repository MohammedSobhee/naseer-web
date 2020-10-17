<script src="{{url('/')}}/assets/global/plugins/respond.min.js"></script>
<script src="{{url('/')}}/assets/global/plugins/excanvas.min.js"></script>
<script src="{{url('/')}}/assets/global/plugins/ie8.fix.min.js"></script>
<!-- BEGIN CORE PLUGINS -->
<script src="{{url('/')}}/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="{{url('/')}}/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="{{url('/')}}/assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
<script src="{{url('/')}}/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js"
        type="text/javascript"></script>
<script src="{{url('/')}}/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="{{url('/')}}/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js"
        type="text/javascript"></script>
<!-- END CORE PLUGINS -->


<script src="{{url('/')}}/assets/global/plugins/bootstrap-toastr/toastr.min.js" type="text/javascript"></script>
<script src="{{url('/')}}/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<script>
    var baseURL = '{{url(admin_vw())}}';
    var baseAssets = '{{url('assets')}}';

    $(window).keydown(function (event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });


</script>
<script>
    var csrf_token = $('meta[name="csrf-token"]').attr('content');
</script>
@yield('js')


<script src="{{url('/')}}/assets/pages/scripts/ui-toastr.min.js" type="text/javascript"></script>


<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="{{url('/')}}/assets/layouts/layout2/scripts/layout.min.js" type="text/javascript"></script>
<script src="{{url('/')}}/assets/layouts/layout2/scripts/demo.min.js" type="text/javascript"></script>
<script src="{{url('/')}}/assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
<script src="{{url('/')}}/assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
<!-- END THEME LAYOUT SCRIPTS -->

<script src="{{url('/')}}/assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>

<script src="https://js.pusher.com/7.0/pusher.min.js"></script>

<script>
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "positionClass": "toast-top-left",
        "onclick": null,
        "showDuration": "1000",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    function empty_frm(target) {

        $(target).find("input").not("input[type='hidden']").val('');
        $(target).find("textarea").val('');
        $(target).find("select").val('');
        $(target).find(".select2").val(null).trigger('change');
    }

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('777ac0c530714c6e8f4b', {
        cluster: 'mt1'
    });

    var channel = pusher.subscribe('private-update-request');
    channel.bind('my-event', function (data) {
        alert(JSON.stringify(data));
    });
</script>

@stack('js')
