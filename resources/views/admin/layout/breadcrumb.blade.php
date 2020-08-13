<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            {{--$back_url or $title or --}}
            <i class="{{$icon ?? 'icon-home'}}"></i>
            <a href="{{$back_url ?? ''}}">{{$title ?? 'الصفحة الرئيسية'}}</a>
            @if(isset($sub_title))
                <i class="fa fa-angle-right"></i>
            @endif
        </li>
        @if(isset($sub_title))

            <li>
                <span>{!! $sub_title !!}</span>
            </li>
        @endif

    </ul>

</div>