<div class="page-sidebar-wrapper">
    <!-- END SIDEBAR -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <ul class="page-sidebar-menu  page-header-fixed page-sidebar-menu-hover-submenu " data-keep-expanded="false"
            data-auto-scroll="true" data-slide-speed="200">

            <li class="nav-item @if(preg_match('/home/i',url()->current())) start active open @endif">
                <a href="{{url(admin_vw().'/home')}}" class="nav-link nav-toggle">
                    <i class="icon-home"></i>
                    <span class="title">الصفحة الرئيسية</span>
                    <span class="selected"></span>
                    {{--<span class="arrow"></span>--}}
                </a>
            </li>
            <li class="nav-item @if(preg_match('/admins/i',url()->current())) start active open @endif ">
                <a href="{{url(admin_vw().'/admins')}}" class="nav-link nav-toggle">
                    <i class="fa fa-users"></i>
                    <span class="title">مديرو النظام</span>
                    <span class="selected"></span>
                </a>
            </li>
            <li class="nav-item @if(preg_match('/user/i',url()->current())) start active open @endif ">
                <a href="{{url(admin_vw().'/users')}}" class="nav-link nav-toggle">
                    <i class="icon-users"></i>
                    <span class="title">ادارة المستخدمين</span>
                    <span class="selected"></span>
                    <span class="arrow"></span>

                </a>
                <ul class="sub-menu">
                    <li class="nav-item @if(preg_match('/cities/i',url()->current())) start active open @endif  ">
                        <a href="{{url(admin_constant_url().'/cities')}}" class="nav-link ">
                            <span class="title">المستخدمين  </span>
                        </a>
                    </li>
                    <li class="nav-item @if(preg_match('/cities/i',url()->current())) start active open @endif  ">
                        <a href="{{url(admin_constant_url().'/cities')}}" class="nav-link ">
                            <span class="title">مقدمو الخدمات  </span>
                        </a>
                    </li>


                </ul>

            </li>
            <li class="nav-item @if(preg_match('/admins/i',url()->current())) start active open @endif ">
                <a href="{{url(admin_vw().'/admins')}}" class="nav-link nav-toggle">
                    <i class="icon-layers"></i>
                    <span class="title">الطلبات</span>
                    <span class="selected"></span>
                </a>
            </li>
            <li class="nav-item @if(preg_match('/admins/i',url()->current())) start active open @endif ">
                <a href="{{url(admin_vw().'/admins')}}" class="nav-link nav-toggle">
                    <i class="icon-layers"></i>
                    <span class="title">الخدمات</span>
                    <span class="selected"></span>
                </a>
            </li>
            <li class="nav-item  @if(preg_match('/constant/i',url()->current())) start active open @endif ">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">الثوابت</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">

                    <li class="nav-item @if(preg_match('/cities/i',url()->current())) start active open @endif  ">
                        <a href="{{url(admin_constant_url().'/cities')}}" class="nav-link ">
                            <span class="title">انواع مقدمو الخدمات  </span>
                        </a>
                    </li>
                    <li class="nav-item @if(preg_match('/cities/i',url()->current())) start active open @endif  ">
                        <a href="{{url(admin_constant_url().'/cities')}}" class="nav-link ">
                            <span class="title">مقدمة البرنامج  </span>
                        </a>
                    </li>
                    <li class="nav-item @if(preg_match('/cities/i',url()->current())) start active open @endif  ">
                        <a href="{{url(admin_constant_url().'/cities')}}" class="nav-link ">
                            <span class="title">الدول  </span>
                        </a>
                    </li>
                    <li class="nav-item @if(preg_match('/cities/i',url()->current())) start active open @endif  ">
                        <a href="{{url(admin_constant_url().'/cities')}}" class="nav-link ">
                            <span class="title">المدن  </span>
                        </a>
                    </li>

                </ul>
            </li>

        </ul>


        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>
