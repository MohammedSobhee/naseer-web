<div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner ">
        <!-- BEGIN LOGO -->
{{--        <div class="page-logo">--}}
{{--            <a href="{{url(admin_vw().'/home')}}">--}}
{{--                <img src="{{url('/')}}/assets/site/images/logo.png" alt="logo" class="logo-default" width="30%"/>--}}
{{--            </a>--}}
{{--            <div class="menu-toggler sidebar-toggler">--}}
{{--                <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->--}}
{{--            </div>--}}
{{--        </div>--}}


        <div class="page-logo" >
            <a href="{{url(admin_vw().'/home')}}" style="margin: 0px; text-align: center; width: 87%;">
                <img src="{{url('/')}}/assets/layouts/layout/img/logo.png" alt="logo" class="logo-default" style="width: 38%;margin: 0px;" /> </a>
            <div class="menu-toggler sidebar-toggler">
                <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
            </div>
        </div>

        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse"
           data-target=".navbar-collapse"> </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN PAGE TOP -->
        <div class="page-top">
            <!-- BEGIN TOP NAVIGATION MENU -->
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                    <li class="dropdown dropdown-user">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                           data-close-others="true">
{{--                            <img alt="" class="img-circle"--}}
{{--                                 src="{{url('/')}}/assets/layouts/layout2/img/avatar3_small.jpg"/>--}}
                            <span class="username username-hide-on-mobile"> {{auth()->guard('admin')->user()->username}} </span>
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default">
{{--                            <li>--}}
{{--                                <a href="{{url(admin_vw().'/profile')}}">--}}
{{--                                    <i class="icon-user"></i> الصفحة الشخصية </a>--}}
{{--                            </li>--}}
                            <li>
                                <a href="{{ route('admin.logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="icon-key"></i> تسجيل الخروج </a>
                            </li>
                            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST"
                                  style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </ul>
                    </li>
                    <!-- END USER LOGIN DROPDOWN -->
                </ul>
            </div>
            <!-- END TOP NAVIGATION MENU -->
        </div>
        <!-- END PAGE TOP -->
    </div>
    <!-- END HEADER INNER -->
</div>
