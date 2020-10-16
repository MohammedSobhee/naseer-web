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
            <li class="nav-item @if(preg_match('/user|service-providers/i',url()->current())) start active open @endif ">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-users"></i>
                    <span class="title">ادارة المستخدمين</span>
                    <span class="selected"></span>
                    <span class="arrow"></span>

                </a>
                <ul class="sub-menu">
                    <li class="nav-item @if(preg_match('/user/i',url()->current())) start active open @endif  ">
                        <a href="{{url(admin_vw().'/users')}}" class="nav-link ">
                            <span class="title">المستخدمين  </span>
                        </a>
                    </li>
                    <li class="nav-item @if(preg_match('/service-providers/i',url()->current())) start active open @endif  ">
                        <a href="{{url(admin_vw().'/service-providers')}}" class="nav-link ">
                            <span class="title">مزودي الخدمات  </span>
                        </a>
                    </li>


                </ul>

            </li>
            <li class="nav-item @if(preg_match('/requests/i',url()->current())) start active open @endif ">
                <a href="{{url(admin_vw().'/requests')}}" class="nav-link nav-toggle">
                    <i class="icon-basket"></i>
                    <span class="title">الطلبات</span>
                    <span class="selected"></span>
                </a>
            </li>
            <li class="nav-item @if(preg_match('/rates/i',url()->current())) start active open @endif ">
                <a href="{{url(admin_vw().'/rates')}}" class="nav-link nav-toggle">
                    <i class="icon-star"></i>
                    <span class="title">التقييمات</span>
                    <span class="selected"></span>
                </a>
            </li>
            <li class="nav-item @if(preg_match('/contracts/i',url()->current())) start active open @endif ">
                <a href="{{url(admin_vw().'/contracts')}}" class="nav-link nav-toggle">
                    <i class="icon-book-open"></i>
                    <span class="title">العقود</span>
                    <span class="selected"></span>
                </a>
            </li>
            <li class="nav-item @if(preg_match('/services/i',url()->current())) start active open @endif ">
                <a href="{{url(admin_vw().'/services')}}" class="nav-link nav-toggle">
                    <i class="icon-layers"></i>
                    <span class="title">الخدمات</span>
                    <span class="selected"></span>
                </a>
            </li>

            <li class="nav-item  @if(preg_match('/constants/i',url()->current())) start active open @endif ">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">الثوابت</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">

                    <li class="nav-item @if(preg_match('/service-provider-types/i',url()->current())) start active open @endif  ">
                        <a href="{{url(admin_constant_url().'/service-provider-types')}}" class="nav-link ">
                            <span class="title">أنواع مزودي الخدمات  </span>
                        </a>
                    </li>
                    <li class="nav-item @if(preg_match('/intros/i',url()->current())) start active open @endif  ">
                        <a href="{{url(admin_constant_url().'/intros')}}" class="nav-link ">
                            <span class="title">جمل تعريفية  </span>
                        </a>
                    </li>
                    <li class="nav-item @if(preg_match('/countries/i',url()->current())) start active open @endif  ">
                        <a href="{{url(admin_constant_url().'/countries')}}" class="nav-link ">
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
            <li class="nav-item @if(preg_match('/settings/i',url()->current())) start active open @endif ">
                <a href="{{url(admin_vw().'/settings')}}" class="nav-link nav-toggle">
                    <i class="fa fa-cogs"></i>
                    <span class="title">الاعدادات</span>
                    <span class="selected"></span>
                </a>
            </li>
        </ul>


        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>
