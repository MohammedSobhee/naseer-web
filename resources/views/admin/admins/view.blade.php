@extends(admin_layout_vw().'.index')

@section('css')
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="{{url('/')}}/assets/global/css/components-md-rtl.min.css" rel="stylesheet" id="style_components"
          type="text/css"/>
    <link href="{{url('/')}}/assets/global/css/plugins-md-rtl.min.css" rel="stylesheet" type="text/css"/>

    <link href="{{url('/')}}/assets/pages/css/profile-rtl.min.css" rel="stylesheet" type="text/css"/>

    <!-- END THEME GLOBAL STYLES -->
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PROFILE SIDEBAR -->
            <div class="profile-sidebar">
                <!-- PORTLET MAIN -->
                <div class="portlet light profile-sidebar-portlet">
                    <!-- SIDEBAR USERPIC -->
                    <div class="profile-userpic">
                        <img src="{{url('/')}}/assets/pages/media/profile/profile_user.jpg" class="img-responsive"
                             alt=""></div>
                    <!-- END SIDEBAR USERPIC -->
                    <!-- SIDEBAR USER TITLE -->
                    <div class="profile-usertitle">
                        <div class="profile-usertitle-name"> @if($user->is_active) <i class="icon-user-following"
                                                                                      style="color: blue"
                                                                                      title="فعّال"></i> @else <i
                                    class="icon-user-unfollow" style="color: red" title="غير مفعّل"></i> @endif</div>
                        <div class="profile-usertitle-name"> {{$user->first_name.' '.$user->last_name}}</div>
                        <div class="profile-usertitle-name" style="font-size: 12px"> {{$user->nickname}}</div>
                        <div class="profile-usertitle-job" style="text-transform: lowercase;"> {{$user->username}}</div>
                    </div>
                    <!-- END SIDEBAR USER TITLE -->

                    <div class="profile-usermenu">
                        <ul class="nav">
                            <li>
                                <a href="javascript:;">
                                    <i class="icon-present"></i> {{$user->birth_date}} </a>
                            </li>
                            <li>

                                <a href="javascript:;">
                                    <i class="icon-pointer"></i> {{$user->Country->name}} - {{$user->City->name}} </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <i class="icon-screen-smartphone"></i> {{$user->mobile}} @if($user->is_confirm_code)
                                        <i class="icon-check" style="color: blue" title="متحقق"></i> @endif </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <i class="icon-envelope-open"></i> {{$user->email}} @if($user->email_verified_at)
                                        <i class="icon-check" style="color: blue" title="متحقق"></i> @endif </a>
                            </li>
                        </ul>
                    </div>


                </div>
                <!-- END PORTLET MAIN -->
            </div>
            <div class="profile-sidebar">
                <!-- PORTLET MAIN -->
                <div class=" portlet light portlet-title tabbable-line">
                    <div class="caption caption-md">
                        <i class="icon-globe theme-font hide"></i>
                        <span class="caption-subject font-blue-madison bold uppercase">بيانات اخرى</span>
                    </div>

                </div>
                <div class="portlet light profile-sidebar-portlet">
                    <div class="profile-usermenu" style="margin-top: 0px;">
                        <ul class="nav">
                            <li>
                                <a href="javascript:;">
                                     الطول:{{$user->height}} - الوزن: {{$user->weight}} </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                     القدم المفضلة: {{$user->favorite_leg}} </a>
                            </li>
                            <li>
                                <a href="javascript:;"> @if(isset($user->PrimePosition)) الموقع الاساسي: {{$user->PrimePosition->name}}@endif
                                    @if(isset($user->SecondaryPosition)) الموقع الثانوي {{$user->SecondaryPosition->name}} @endif
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>


                <!-- END PORTLET MAIN -->
            </div>
            <!-- END BEGIN PROFILE SIDEBAR -->
        </div>
    </div>
@endsection

@section('js')

    <!-- END PAGE LEVEL PLUGINS -->
    <script src="{{url('/')}}/assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>

    <!-- BEGIN THEME GLOBAL SCRIPTS -->
    <script src="{{url('/')}}/assets/global/scripts/app.min.js" type="text/javascript"></script>
    <!-- END THEME GLOBAL SCRIPTS -->
    <script src="{{url('/')}}/assets/pages/scripts/profile.min.js" type="text/javascript"></script>
    <script src="{{url('/')}}/assets/js/users.js" type="text/javascript"></script>


@stop