@extends(admin_layout_vw().'.index')

@section('css')
    <link href="{{url('/')}}/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{url('/')}}/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet"
          type="text/css"/>
    <!-- END PAGE LEVEL PLUGINS -->

@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">

            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="fa fa-cog font-dark"></i>
                        <span class="caption-subject bold uppercase"> العقود</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    {!! Form::open(['method'=>'PUT','class'=>'form-horizontal','files'=>true,'id'=>'formEdit']) !!}

                    <div class="form-group">
                        <label for="services" class="col-md-2 control-label">الخدمات</label>
                        <div class="col-md-9">
                            <select class="form-control select2" multiple name="service_ids[]" id="service_ids"
                                    data-placeholder="الخدمات">
                                @foreach($services as $service)
                                    <option value="{{$service->id}}"
                                            @if(in_array($service->id,$selected_services)) selected @endif>{{$service->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="contract" class="col-md-2 control-label">تفاصيل عقد الاتفاق</label>
                        <div class="col-md-9">
                            <textarea rows="9" class="form-control ckeditor" name="text"
                                      placeholder="تفاصيل عقد الاتفاق">{!! $contract->text ?? '' !!}</textarea>
                        </div>
                    </div>

                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-circle green btn-md save"><i
                                        class="fa fa-check"></i>
                                    حفظ التغيرات
                                </button>
                            </div>
                        </div>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-gift"></i>متغيرات العقد
                    </div>
                </div>
                <div class="portlet-body form">
                    <div class="form-body">
                        <div class="form-group">
                            <form action="#" class="mt-repeater form-horizontal">
                                <h5 class="mt-repeater-title">بعد اضافة المتغير قم بأخذ قيمة المتغير واضافتها في نص
                                    العقد بدلاً من الفراغ</h5>
                                @foreach($contract->fields as $field)
                                    <div data-repeater-list="group-a">
                                        <div data-repeater-item class="mt-repeater-item">
                                            <!-- jQuery Repeater Container -->
                                            <div class="mt-repeater-input">
                                                <label class="control-label">تابع لـ</label>
                                                <br/>
                                                <select name="type" id="type" class="form-control">
                                                    <option value="">حدد تابع لـ</option>
                                                    <option value="user" @if($field->type == 'user') selected @endif>
                                                        المُوكِل
                                                    </option>
                                                    <option value="service_provider"
                                                            @if($field->type == 'service_provider') selected @endif>مزود
                                                        الخدمة
                                                    </option>
                                                </select>
                                            </div>

                                            <div class="mt-repeater-input">
                                                <label class="control-label">قيمة المتغير</label>
                                                <br/>
                                                <input type="text" name="slug" id="slug" class="form-control" readonly
                                                       value="{{$field->slug}}"/>
                                                <div class="hint red">يتم تحديدها بعد حفظ القيمة</div>
                                            </div>

                                            <div class="mt-repeater-input">
                                                <a href="javascript:;"
                                                   class="btn btn-success save mt-repeater-delete">
                                                    <i class="fa fa-check"></i> حفظ</a>
                                                <a href="javascript:;" data-repeater-delete
                                                   class="btn btn-danger mt-repeater-delete">
                                                    <i class="fa fa-close"></i> حذف</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <div data-repeater-list="group-a">
                                    <div data-repeater-item class="mt-repeater-item">
                                        <!-- jQuery Repeater Container -->
                                        <div class="mt-repeater-input">
                                            <label class="control-label">تابع لـ</label>
                                            <br/>
                                            <select name="type" id="type" class="form-control">
                                                <option value="">حدد تابع لـ</option>
                                                <option value="user">المُوكِل</option>
                                                <option value="service_provider">مزود الخدمة</option>
                                            </select>
                                        </div>

                                        <div class="mt-repeater-input">
                                            <label class="control-label">قيمة المتغير</label>
                                            <br/>
                                            <input type="text" name="slug" id="slug" class="form-control" readonly
                                                   value=""/>
                                            <div class="hint">يتم تحديدها بعد حفظ القيمة</div>
                                        </div>

                                        <div class="mt-repeater-input">
                                            <a href="{{url(admin_vw().'/contracts/add-field/'.$contract->id)}}"
                                               class="btn btn-success save  add-field mt-repeater-delete">
                                                <i class="fa fa-check"></i> حفظ</a>
                                            <a href="javascript:;" data-repeater-delete
                                               class="btn btn-danger mt-repeater-delete">
                                                <i class="fa fa-close"></i> حذف</a>
                                        </div>
                                    </div>
                                </div>

                                <a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-add">
                                    <i class="fa fa-plus"></i> اضافة متغير جديد</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')

    <!-- BEGIN PAGE LEVEL PLUGINS -->


    <script src="{{url('/')}}/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
    <script src="{{url('/')}}/assets/global/plugins/jquery-repeater/jquery.repeater.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL SCRIPTS -->
    <script src="{{url('/')}}/assets/global/scripts/app.min.js" type="text/javascript"></script>
    <!-- END THEME GLOBAL SCRIPTS -->
    <script src="{{url('/')}}/assets/pages/scripts/form-repeater.min.js" type="text/javascript"></script>
    <script src="{{url('/')}}/assets/pages/scripts/components-select2.min.js" type="text/javascript"></script>
    <script src="{{url('/')}}/assets/js/contracts.js" type="text/javascript"></script>
    <script src="{{url('/')}}/assets/global/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>

@stop
