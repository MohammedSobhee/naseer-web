<link href="{{url('/')}}/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet"
      type="text/css"/>
<link href="{{url('/')}}/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css"/>
<link href="{{url('/')}}/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet"
      type="text/css"/>

<script src="{{url('/')}}/assets/global/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>

<link href="{{url('/')}}/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
<link href="{{url('/')}}/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
<link href="{{url('/')}}/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
<style>
    .datepicker{
        width: fit-content !important;
    }
</style>
<div class="modal fade" id="{{$modal_id}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"> {!! $modal_title !!}</h4>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="portlet-body form">
                            {!! Form::open(['method'=>$form['method'],'id'=>$form['form_id'],'class'=>'form-horizontal form','url'=>$form['url'] ,'files'=>true]) !!}
                            <div class="alert alert-danger" role="alert" style="display: none"></div>

                            <div class="form-body">
                                @foreach($form['fields'] as $key=> $fields)
                                    @if($fields == 'image' || $fields == 'video')
                                        <div class="form-group ">
                                            <label class="control-label col-md-3">{{$form['fields_ar'][$key]}}</label>
                                            <div class="col-md-9">
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-preview thumbnail" data-trigger="fileinput"
                                                         style="width: 200px; height: 150px;">
                                                        @if(isset($form['values']))
                                                            @if($fields == 'video')
                                                                <video src="{{$form['values'][$key]}}" controls
                                                                       width="200"></video>
                                                            @else
                                                                <img src="{{$form['values'][$key]}}">

                                                            @endif
                                                        @else
                                                            <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image"
                                                                 alt=""/>

                                                        @endif
                                                    </div>
                                                    <div>
                                                            <span class="btn red btn-outline btn-file">
                                                                <span class="fileinput-new"> اختيار </span>
                                                                <span class="fileinput-exists"> تغير </span>
                                                                <input type="file" name="{{$key}}"
                                                                       id="{{$key}}"> </span>
                                                        <a href="javascript:;" class="btn red fileinput-exists"
                                                           data-dismiss="fileinput">
                                                            افراغ </a>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    @endif
                                    @if($fields == 'text')
                                        <div class="form-group {{$key}}">
                                            <label class="col-md-3 control-label">{{$form['fields_ar'][$key]}}</label>
                                            <div class="col-md-9">
                                                <input type="text" name="{{$key}}" id="{{$key}}" class="form-control"
                                                       placeholder="{{$form['fields_ar'][$key]}}"
                                                       @if(isset($form['values'])) value="{{$form['values'][$key]}}" @endif>
                                            </div>
                                        </div>
                                    @endif
                                    @if($fields == 'number')
                                        <div class="form-group {{$key}}">
                                            <label class="col-md-3 control-label">{{$form['fields_ar'][$key]}}</label>
                                            <div class="col-md-9">
                                                <input type="number" name="{{$key}}" id="{{$key}}" class="form-control"
                                                       placeholder="{{$form['fields_ar'][$key]}}"
                                                       @if(isset($form['values'])) value="{{$form['values'][$key]}}" @endif>
                                            </div>
                                        </div>
                                    @endif
                                    @if($fields == 'time')
                                        <div class="form-group {{$key}}">
                                            <label class="control-label col-md-3">{{$form['fields_ar'][$key]}}</label>
                                            <div class="col-md-3">
                                                <div class="input-icon">
                                                    <i class="fa fa-clock-o"></i>
                                                    <input type="text" name="{{$key}}" id="{{$key}}"
                                                           class="form-control timepicker timepicker-24"
                                                           @if(isset($form['values'])) value="{{$form['values'][$key]}}" @endif>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                        @if($fields == 'email')
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">{{$form['fields_ar'][$key]}}</label>
                                                <div class="col-md-9">
                                                    <input type="email" name="{{$key}}" id="{{$key}}"
                                                           class="form-control"
                                                           placeholder="{{$form['fields_ar'][$key]}}"
                                                           @if(isset($form['values'])) value="{{$form['values'][$key]}}" @endif>
                                                </div>
                                            </div>
                                        @endif
                                        @if($fields == 'password')
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">{{$form['fields_ar'][$key]}}</label>
                                                <div class="col-md-9">
                                                    <input type="password" name="{{$key}}" id="{{$key}}"
                                                           class="form-control"
                                                           placeholder="{{$form['fields_ar'][$key]}}">
                                                </div>
                                            </div>
                                        @endif
                                    @if($fields == 'date-time')
                                        <div class="form-group">
                                            <label class="control-label col-md-3">{{$form['fields_ar'][$key]}}</label>
                                            <div class="col-md-3">
                                                <div class="input-group date form_datetime input-large"  data-date-format="yyyy-mm-dd H:i:s">
                                                    <input type="text" size="16" readonly class="form-control" name="{{$key}}" id="{{$key}}" @if(isset($form['values'])) value="{{$form['values'][$key]}}" @endif>
                                                    <span class="input-group-btn">
                                                                        <button class="btn default date-reset" type="button">
                                                                            <i class="fa fa-times"></i>
                                                                        </button>
                                                                        <button class="btn default date-set" type="button">
                                                                            <i class="fa fa-calendar"></i>
                                                                        </button>
                                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                        @if($fields == 'date')
                                        <div class="form-group">
                                            <label class="control-label col-md-3">{{$form['fields_ar'][$key]}}</label>
                                            <div class="col-md-3">

                                            <div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                                                <input type="text" class="form-control" readonly  name="{{$key}}" id="{{$key}}"
                                                       @if(isset($form['values'])) value="{{$form['values'][$key]}}" @endif>
                                                <span class="input-group-btn">
                                                            <button class="btn default" type="button">
                                                                <i class="fa fa-calendar"></i>
                                                            </button>
                                                        </span>
                                            </div>
                                        </div>
                                        </div>
                                    @endif

                                    @if($fields == 'date-range')

                                        <div class="form-group">
                                            <label class="col-md-3 control-label">{{$form['fields_ar'][$key]}}</label>
                                            <div class="col-md-9">
                                                <div class="input-group input-large date-picker input-daterange"
                                                     data-date-format="yyyy-mm-dd">
                                                    <input type="text" class="form-control" name="start_date"
                                                           autocomplete="off"
                                                           @if(isset($form['values'])) value="{{$form['values']['start_date']}}"
                                                           @endif
                                                           placeholder="تاريخ البداية">
                                                    <span class="input-group-addon"> الى </span>
                                                    <input type="text" class="form-control" name="end_date"
                                                           autocomplete="off"
                                                           placeholder="تاريخ النهاية"
                                                           @if(isset($form['values'])) value="{{$form['values']['end_date']}}" @endif >
                                                </div>
                                            </div>
                                        </div>


                                    @endif
                                    @if($fields == 'textarea')
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">{{$form['fields_ar'][$key]}}</label>
                                            <div class="col-md-9">
                                                <textarea name="{{$key}}" id="{{$key}}" rows="5"
                                                          placeholder="{{$form['fields_ar'][$key]}}"
                                                          class="form-control">@if(isset($form['values'])){{$form['values'][$key]}}@endif</textarea>
                                            </div>
                                        </div>
                                    @endif

                                        @if($fields == 'ckeditor')
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">{{$form['fields_ar'][$key]}}</label>

                                                <div class="col-md-9">
                                                <textarea name="{{$key}}" id="{{$key}}" rows="5"
                                                          placeholder="{{$form['fields_ar'][$key]}}"
                                                          class="form-control {{$fields}}">@if(isset($form['values'])){{$form['values'][$key]}}@endif</textarea>
                                                </div>

                                                <script>
                                                    CKEDITOR.replace('{{$key}}');
                                                </script>
                                            </div>
                                        @endif
                                    @if(is_array($fields))
                                        <div class="form-group {{$key}}">
                                            <label class="col-md-3 control-label">{{$form['fields_ar'][$key]}}</label>
                                            <div class="col-md-9">
                                                <div class="input-icon">
                                                    <select class="form-control select" name="{{$key}}"
                                                            id="{{$key}}">
                                                        @foreach($fields as $k=> $field)
                                                            <option value="{{$k}}"
                                                                    @if(isset($form['values']) && $form['values'][$key] == $k) selected @endif>{{ucfirst($field)}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                        @if(is_object($fields) && strpos($key,'[]') !== false)
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">{{$form['fields_ar'][$key]}}</label>
                                                <div class="col-md-9">
                                                    <div class="input-icon">
                                                        <select class="form-control select2 {{$key}}" name="{{$key}}" @if(strpos($key,'[]') !== false) multiple @endif data-placeholder="اختيار {{$form['fields_ar'][$key]}} ..." id="{{$key}}" style="padding: 0;">
                                                            <option></option>

                                                            @if(strpos($key,'[]') !== false && isset($form['values'][$key]))
                                                                @foreach($form['values'][$key] as $item)
                                                                    <option value="{{$item->id}}"
                                                                            @if(in_array($item->id,$roles_id)) selected @endif>{{($item->name)}}</option>

                                                                @endforeach
                                                                    @foreach($fields as  $k => $field)

                                                                        @if(in_array($field->id,$form['values']['role_res[]'])) @continue @endif
                                                                        <option value="{{$field->id}}">{{($field->name)}}</option>
                                                                    @endforeach
                                                            @else
                                                                @foreach($fields as $field)
                                                                    <option value="{{$field->id}}"
                                                                            @if(isset($form['values']) && $form['values'][$key] == $field->id) selected @endif>{{ucfirst($field->name)}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                    @if(is_object($fields)  && strpos($key,'[]') === false)
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">{{$form['fields_ar'][$key]}}</label>
                                            <div class="col-md-9">
                                                <div class="input-icon">
                                                    <select class="form-control select2 {{$key}}" name="{{$key}}"
                                                            id="{{$key}}"
                                                            style="    padding: 0;">
                                                        <option>{{$form['fields_ar'][$key]}}</option>
                                                        @foreach($fields as $field)
                                                            <option value="{{$field->id}}"
                                                                    @if(isset($form['values']) && $form['values'][$key] == $field->id) selected @endif>{{ucfirst($field->name)}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <button type="submit" class="btn btn-circle green btn-md save"><i
                                                        class="fa fa-check"></i>
                                                حفظ
                                            </button>
                                            <button type="button" class="btn btn-circle btn-md red"
                                                    data-dismiss="modal">
                                                <i class="fa fa-times"></i>
                                                اغلاق
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>

<script src="{{url('/')}}/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<script src="{{url('/')}}/assets/pages/scripts/components-select2.min.js" type="text/javascript"></script>

<script src="{{url('/')}}/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"
        type="text/javascript"></script>
<script src="{{url('/')}}/assets/global/plugins/moment.min.js" type="text/javascript"></script>
<script src="{{url('/')}}/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>

<script src="{{url('/')}}/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="{{url('/')}}/assets/global/scripts/app.min.js" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{url('/')}}/assets/pages/scripts/components-date-time-pickers.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
