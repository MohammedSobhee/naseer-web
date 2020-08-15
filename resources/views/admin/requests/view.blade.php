<div class="portlet light">
    <div class="portlet-title">
        <div class="caption font-dark">
            <i class="icon-layers font-dark"></i>
            <span class="caption-subject bold uppercase"> تفاصيل الطلب </span>
        </div>

    </div>
    <div class="portlet-body form">
        <!-- BEGIN FORM-->
        <form action="#" class="form-horizontal form-bordered">
            <div class="form-body">
                <div class="form-group">
                    <label class="control-label col-md-3">رقم الطلب</label>
                    <div class="col-md-3">
                        {{$order->id}}
                    </div>
                    <label class="control-label col-md-3">المدينة</label>
                    <div class="col-md-3">
                        {{$order->City->name ?? '-'}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">مقدم الطلب</label>
                    <div class="col-md-3">
                        {{$order->User->name ?? '-'}}
                    </div>
                    <label class="control-label col-md-3">نوع الخدمة</label>
                    <div class="col-md-3">
                        {{$order->Service->name ?? '-'}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">تفاصيل الطلب</label>
                    <div class="col-md-3">
                        {{$order->case_text ?? '-'}}
                    </div>
                    <label class="control-label col-md-1">مرفق ملف </label>
                    <div class="col-md-1">
                        @if(isset($order->case_file))
                            <a href="{{$order->case_file}}" download><i class="fa fa-download"></i></a>
                        @else
                            -
                        @endif
                    </div>
                    <label class="control-label col-md-1">مرفق صوت </label>
                    <div class="col-md-1">
                        @if(isset($order->case_audio))
                            <a href="{{$order->case_audio}}" download><i class="fa fa-download"></i></a>
                        @else
                            -
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">الاثباتات و الأدلة</label>
                    <div class="col-md-3">
                        {{$order->evidences_text ?? '-'}}
                    </div>
                    <label class="control-label col-md-1">مرفق ملف </label>
                    <div class="col-md-1">
                        @if(isset($order->evidences_file))
                            <a href="{{$order->evidences_file}}" download><i class="fa fa-download"></i></a>
                        @else
                            -
                        @endif
                    </div>
                    <label class="control-label col-md-1">مرفق صوت </label>
                    <div class="col-md-1">
                        @if(isset($order->evidences_audio))
                            <a href="{{$order->evidences_audio}}" download><i class="fa fa-download"></i></a>
                        @else
                            -
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">النتائج</label>
                    <div class="col-md-3">
                        {{$order->preferred_outcomes_text ?? '-'}}
                    </div>
                    <label class="control-label col-md-1">مرفق ملف </label>
                    <div class="col-md-1">
                        @if(isset($order->preferred_outcomes_file))
                            <a href="{{$order->preferred_outcomes_file}}" download><i class="fa fa-download"></i></a>
                        @else
                            -
                        @endif
                    </div>
                    <label class="control-label col-md-1">مرفق صوت </label>
                    <div class="col-md-1">
                        @if(isset($order->preferred_outcomes_audio))
                            <a href="{{$order->preferred_outcomes_audio}}" download><i class="fa fa-download"></i></a>
                        @else
                            -
                        @endif
                    </div>
                </div>

                @if($order->service_id == 1)
                    <div class="form-group text-center" style="background-color:#002D5D; color: #FFFFFF">
                        <label class="control-label col-md-12 main-label">{{$order->Service->name}}</label>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2">الخدمة الفرعية</label>
                        <div class="col-md-2">
                            {{$order->CourtAndLawsuit->SubService->name}}
                        </div>
                        <label class="control-label col-md-2">المدعي أو المدعي عليه </label>
                        <div class="col-md-2">
                            {{$order->CourtAndLawsuit->prosecutor_defender}}

                        </div>
                        <label class="control-label col-md-2">طبيعة المدعي عليه</label>
                        <div class="col-md-2">
                            {{$order->CourtAndLawsuit->lawsuit_nature}}

                        </div>
                    </div>
                    <div class="form-group">

                        <label class="control-label col-md-2">بلد المدعي عليه </label>
                        <div class="col-md-1">
                            {{$order->CourtAndLawsuit->Country->name}}
                        </div>
                        <label class="control-label col-md-3">دعوى او اثبات </label>
                        <div class="col-md-2">
                            {{$order->CourtAndLawsuit->lawsuit_proof}}
                        </div>

                    </div>
                    <div  class="form-group">

                        <label class="control-label col-md-2">مراجعة عقود </label>
                        <div class="col-md-2">
                            {{$order->CourtAndLawsuit->court_name}}
                        </div>
                        <label class="control-label col-md-2">بلد العقار </label>
                        <div class="col-md-2">
                            {{$order->CourtAndLawsuit->property_country}}
                        </div>
                        <label class="control-label col-md-2">اسم المحكمة </label>
                        <div class="col-md-2">
                            {{$order->CourtAndLawsuit->issue_procuration}}
                        </div>
                    </div>

                @endif
                @if($order->service_id == 5)
                    <div class="form-group text-center" style="background-color:#002D5D; color: #FFFFFF">
                        <label class="control-label col-md-12 main-label">{{$order->Service->name}}</label>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2">الخدمة الفرعية</label>
                        <div class="col-md-2">
                            {{$order->AnnualLegalContract->SubService->name}}
                        </div>
                        <label class="control-label col-md-2">النشاط </label>
                        <div class="col-md-2">
                            {{$order->AnnualLegalContract->activity}}

                        </div>
                        <label class="control-label col-md-2">مدة التعاقد</label>
                        <div class="col-md-2">
                            {{$order->AnnualLegalContract->contract_period}}

                        </div>
                    </div>
                    <div class="form-group">

                        <label class="control-label col-md-2">الترافع في الدعاوي </label>
                        <div class="col-md-1">
                            {{$order->AnnualLegalContract->lawsuit_argument}}
                        </div>
                        <label class="control-label col-md-3">اعداد لوائح الادعاء واللوائح الاعتراضية </label>
                        <div class="col-md-2">
                            {{$order->AnnualLegalContract->preparation_interception}}
                        </div>
                        <label class="control-label col-md-2">صياغة عقود </label>
                        <div class="col-md-2">
                            {{$order->AnnualLegalContract->contract_formation}}
                        </div>

                    </div>
                    <div  class="form-group">

                        <label class="control-label col-md-2">مراجعة عقود </label>
                        <div class="col-md-2">
                            {{$order->AnnualLegalContract->contract_revision}}
                        </div>
                        <label class="control-label col-md-2">تقديم الاستشارات القانونية </label>
                        <div class="col-md-2">
                            {{$order->AnnualLegalContract->legal_consultation}}
                        </div>
                        <label class="control-label col-md-2">اصدار وكالات </label>
                        <div class="col-md-2">
                            {{$order->AnnualLegalContract->issue_procuration}}
                        </div>
                    </div>

                @endif
            </div>
        </form>
        <!-- END FORM-->
    </div>

</div>
