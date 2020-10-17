<div class="portlet light">
    <div class="portlet-title">
        <div class="caption font-dark">
            <i class="icon-layers font-dark"></i>
            <span class="caption-subject bold uppercase"> تفاصيل الطلب </span>
        </div>
        <div class="actions">
            @if($order->status == 'assigned')
                {{--                <a href="{{url(admin_vw().'/order-contract/'.$order->id)}}"--}}
                {{--                   class="btn btn-circle btn-info order-contract-mdl">--}}
                {{--                    <i class="fa fa-file"></i>--}}
                {{--                    <span class="hidden-xs"> عقد الاتفاق </span>--}}
                {{--                </a>--}}
                <a class="btn purple btn-outline sbold" data-toggle="modal" href="#contract_mdl"> عقد الاتفاق </a>

            @endif
        </div>
    </div>
    <div class="portlet-body form">
        <!-- BEGIN FORM-->
        <form action="#" class="form-horizontal form-bordered">
            <div class="form-body">
                <div class="form-group">
                    <label class="control-label col-md-2">رقم الطلب</label>
                    <div class="col-md-2">
                        {{$order->id}}
                    </div>
                    <label class="control-label col-md-2">مقدم الطلب</label>
                    <div class="col-md-2">
                        {{$order->User->name ?? '-'}}
                    </div>
                    <label class="control-label col-md-2">المدينة</label>
                    <div class="col-md-2">
                        {{$order->City->name ?? '-'}}
                    </div>

                </div>
                <div class="form-group">

                    <label class="control-label col-md-2"> الخدمة</label>
                    <div class="col-md-3">
                        {{$order->Service->name ?? '-'}}
                    </div>
                    <label class="control-label col-md-1">نوع الخدمة</label>
                    <div class="col-md-1">
                        {{($order->type == 'categorized')?'مصنّفة':'غير مصنّفة' ?? '-'}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2">تفاصيل الطلب</label>
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
                    <label class="control-label col-md-2">الاثباتات و الأدلة</label>
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
                    <label class="control-label col-md-2">النتائج</label>
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
                            {{$order->CourtAndLawsuit->prosecutor_defender_txt}}

                        </div>
                        <label class="control-label col-md-2">طبيعة المدعي عليه</label>
                        <div class="col-md-2">
                            {{$order->CourtAndLawsuit->lawsuit_nature_txt}}

                        </div>
                    </div>
                    <div class="form-group">

                        <label class="control-label col-md-2">بلد المدعي عليه </label>
                        <div class="col-md-1">
                            {{$order->CourtAndLawsuit->Country->name}}
                        </div>
                        <label class="control-label col-md-3">دعوى او اثبات </label>
                        <div class="col-md-2">
                            {{$order->CourtAndLawsuit->lawsuit_proof_txt}}
                        </div>

                    </div>
                    <div class="form-group">

                        <label class="control-label col-md-2">مراجعة عقود </label>
                        <div class="col-md-2">
                            {{$order->CourtAndLawsuit->court_name ?? '-'}}
                        </div>
                        <label class="control-label col-md-2">بلد العقار </label>
                        <div class="col-md-2">
                            {{$order->CourtAndLawsuit->property_country ?? '-'}}
                        </div>
                        <label class="control-label col-md-2">اسم المحكمة </label>
                        <div class="col-md-2">
                            {{$order->CourtAndLawsuit->issue_procuration ?? '-'}}
                        </div>
                    </div>


                @elseif($order->service_id == 2)
                    <div class="form-group text-center" style="background-color:#002D5D; color: #FFFFFF">
                        <label class="control-label col-md-12 main-label">{{$order->Service->name}}</label>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2">الخدمة الفرعية</label>
                        <div class="col-md-2">
                            {{$order->PublicProsecutionAndPolice->SubService->name}}
                        </div>
                        <label class="control-label col-md-2">حالة المتهم </label>
                        <div class="col-md-2">
                            {{$order->PublicProsecutionAndPolice->accused_status_txt}}

                        </div>
                        <label class="control-label col-md-2">الجنس</label>
                        <div class="col-md-2">
                            {{$order->PublicProsecutionAndPolice->accused_gender_txt}}

                        </div>
                    </div>
                @elseif($order->service_id == 4)
                    <div class="form-group text-center" style="background-color:#002D5D; color: #FFFFFF">
                        <label class="control-label col-md-12 main-label">{{$order->Service->name}}</label>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2">الخدمة الفرعية</label>
                        <div class="col-md-2">
                            {{$order->DraftingRegulationAndContract->SubService->name}}
                        </div>
                        <label class="control-label col-md-2">نوع تقديم الخدمة </label>
                        <div class="col-md-2">
                            {{$order->DraftingRegulationAndContract->type_service_provided_txt}}

                        </div>
                    </div>
                @elseif($order->service_id == 5)
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
                    <div class="form-group">

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
                @elseif($order->service_id == 7)
                    <div class="form-group text-center" style="background-color:#002D5D; color: #FFFFFF">
                        <label class="control-label col-md-12 main-label">{{$order->Service->name}}</label>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2">الخدمة الفرعية</label>
                        <div class="col-md-2">
                            {{$order->DivisionOfInheritance->SubService->name}}
                        </div>
                        <label class="control-label col-md-2">تفاصيل الورثة </label>
                        <div class="col-md-2">
                            {{$order->DivisionOfInheritance->heirs_details}}

                        </div>

                    </div>
                    <div class="form-group">
                        @if($order->DivisionOfInheritance->sub_service_id == 18)
                            <label class="control-label col-md-2">المتفقون من الورثة</label>
                            <div class="col-md-2">
                                {{$order->DivisionOfInheritance->agreers}}
                            </div>
                            <label class="control-label col-md-2">المعارضون من الورثة </label>
                            <div class="col-md-2">
                                {{$order->DivisionOfInheritance->against}}

                            </div>
                        @endif

                    </div>
                    @if($order->DivisionOfInheritance->sub_service_id == 17 || $order->DivisionOfInheritance->sub_service_id == 18)

                        <div class="form-group text-center" style="">
                            <label class="control-label col-md-12 main-label">موجودات التركة</label>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2">اموال نقدية</label>
                            <div class="col-md-2">
                                {{$order->DivisionOfInheritance->money}}
                            </div>
                            <label class="control-label col-md-2">عقارات </label>
                            <div class="col-md-2">
                                {{$order->DivisionOfInheritance->real_estate}}

                            </div>
                            <label class="control-label col-md-2">أسهم / سندات </label>
                            <div class="col-md-2">
                                {{$order->DivisionOfInheritance->bonds_shares}}

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2">شركات / مؤسسات </label>
                            <div class="col-md-2">
                                {{$order->DivisionOfInheritance->companies}}

                            </div>
                            <label class="control-label col-md-2">اخرى </label>
                            <div class="col-md-2">
                                {{$order->DivisionOfInheritance->others}}

                            </div>

                        </div>
                    @endif

                @elseif($order->service_id == 8)
                    <div class="form-group text-center" style="background-color:#002D5D; color: #FFFFFF">
                        <label class="control-label col-md-12 main-label">{{$order->Service->name}}</label>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2">الخدمة الفرعية</label>
                        <div class="col-md-2">
                            {{$order->CompaniesRegistrationAndTrademarking->SubService->name}}
                        </div>

                    </div>
                    @if($order->CompaniesRegistrationAndTrademarking->sub_service_id == 23)

                        <div class="form-group">
                            <label class="control-label col-md-2">نوع الوكالة </label>
                            <div class="col-md-2">
                                {{$order->CompaniesRegistrationAndTrademarking->authorization_type_txt}}

                            </div>
                            <label class="control-label col-md-2">عدد الوكلاء </label>
                            <div class="col-md-2">
                                {{$order->CompaniesRegistrationAndTrademarking->agents_num}}

                            </div>
                            <label class="control-label col-md-2">عدد الموكلين </label>
                            <div class="col-md-2">
                                {{$order->CompaniesRegistrationAndTrademarking->clients_num}}

                            </div>

                        </div>
                    @endif
                    @if($order->CompaniesRegistrationAndTrademarking->sub_service_id == 24)

                        <div class="form-group">
                            <label class="control-label col-md-2">قيمة الدين </label>
                            <div class="col-md-2">
                                {{$order->CompaniesRegistrationAndTrademarking->debt_value}}

                            </div>
                            <label class="control-label col-md-2">طريقة التسليم </label>
                            <div class="col-md-2">
                                {{$order->CompaniesRegistrationAndTrademarking->delivery_method_txt}}

                            </div>

                        </div>
                    @endif
                    @if($order->CompaniesRegistrationAndTrademarking->sub_service_id == 25)

                        <div class="form-group">
                            <label class="control-label col-md-2">قيمة العقار </label>
                            <div class="col-md-2">
                                {{$order->CompaniesRegistrationAndTrademarking->property_value}}

                            </div>

                        </div>
                    @endif
                @elseif($order->service_id == 9)
                    <div class="form-group text-center" style="background-color:#002D5D; color: #FFFFFF">
                        <label class="control-label col-md-12 main-label">{{$order->Service->name}}</label>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2">الخدمة الفرعية</label>
                        <div class="col-md-2">
                            {{$order->Arbitration->SubService->name}}
                        </div>
                        <label class="control-label col-md-2">موضوع النزاع </label>
                        <div class="col-md-2">
                            {{$order->Arbitration->subject}}

                        </div>
                    </div>

                    <div class="form-group">

                        <label class="control-label col-md-2">قيمته </label>
                        <div class="col-md-2">
                            {{$order->Arbitration->value}}

                        </div>
                        <label class="control-label col-md-2">اختصاص المحكم </label>
                        <div class="col-md-2">
                            {{$order->Arbitration->specialty_txt}}

                        </div>
                    </div>

                @elseif($order->service_id == 10)
                    <div class="form-group text-center" style="background-color:#002D5D; color: #FFFFFF">
                        <label class="control-label col-md-12 main-label">{{$order->Service->name}}</label>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2">الخدمة الفرعية</label>
                        <div class="col-md-2">
                            {{$order->MarriageOfficer->SubService->name}}
                        </div>
                        <label class="control-label col-md-2">العنوان </label>
                        <div class="col-md-2">
                            {{$order->MarriageOfficer->location}}

                        </div>
                        <label class="control-label col-md-2">الوقت و التاريخ </label>
                        <div class="col-md-2">
                            {{$order->MarriageOfficer->request_datetime}}

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2">رقم بطاقة التعريف</label>
                        <div class="col-md-2">
                            {{$order->MarriageOfficer->client_idno}}
                        </div>
                        <label class="control-label col-md-2">وثائق الفحص الطبي </label>
                        <div class="col-md-2">
                            <a href="{{$order->MarriageOfficer->medical_examination}}" download><i
                                    class="fa fa-download"></i></a>
                        </div>
                        <label class="control-label col-md-2">وثيقة صك الطلاق </label>
                        <div class="col-md-2">
                            <a href="{{$order->MarriageOfficer->divorce_certificate}}" download><i
                                    class="fa fa-download"></i></a>
                        </div>
                    </div>
                @elseif($order->service_id == 12)
                    <div class="form-group text-center" style="background-color:#002D5D; color: #FFFFFF">
                        <label class="control-label col-md-12 main-label">{{$order->Service->name}}</label>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2">الخدمة الفرعية</label>
                        <div class="col-md-2">
                            {{$order->AssignExpert->SubService->name}}
                        </div>
                        <label class="control-label col-md-2">جهة الطلب </label>
                        <div class="col-md-2">
                            {{$order->AssignExpert->request_side_txt}}

                        </div>
                    </div>
                @endif
            </div>
        </form>
        <!-- END FORM-->
    </div>

</div>

<!-- /.modal -->
<div class="modal fade bs-modal-lg" id="contract_mdl" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">عقد الاتفاق</h4>
            </div>
            <div class="modal-body"> {!! $order->contract ?? '' !!} </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">أغلاق</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
