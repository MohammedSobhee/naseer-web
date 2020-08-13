@extends(admin_layout_vw().'.index')

@section('css')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="{{url('/')}}/assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{url('/')}}/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap-rtl.css"
          rel="stylesheet" type="text/css"/>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="{{url('/')}}/assets/global/css/components-md-rtl.min.css" rel="stylesheet" id="style_components"
          type="text/css"/>
    <link href="{{url('/')}}/assets/global/css/plugins-md-rtl.min.css" rel="stylesheet" type="text/css"/>
    <!-- END THEME GLOBAL STYLES -->
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet box red">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-list"></i> {{$label}}
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-toolbar">
                        <div class="form-body">
                            <div class="row">
                                {!! Form::open(['method'=>'POST','url'=>$url_action,'id'=>'save_category_frm','files'=>true]) !!}
                                <div class="form-group">
                                    <div class="col-md-3">
                                        <input id="constant_name" class="form-control constant_name" type="text"
                                               name="constant_name" data-id="" placeholder="{{$placeholder}}">


                                    </div>

                                    <div class="col-md-3 hidden">
                                        <input id="type" class="form-control type" type="hidden"
                                               name="type" data-id="" value="{{$type}}" placeholder="{{$placeholder}}">


                                    </div>
{{--                                    <div class="form-group">--}}
{{--                                        --}}{{--                                        <label class="col-md-3 control-label">{{$form['fields_ar'][$key]}}</label>--}}
{{--                                        <div class="col-md-3">--}}
{{--                                            <div class="input-icon">--}}
{{--                                                <select class="form-control select2" name="type" id="type" disabled>--}}

{{--                                                    <option value="0">نوع التصنيف</option>--}}
{{--                                                    <option value="product" @if($type == 'product') selected @endif>--}}
{{--                                                        منتج--}}
{{--                                                    </option>--}}
{{--                                                    <option value="exchange" @if($type == 'exchange') selected @endif>--}}
{{--                                                        اسعار اجهزة--}}
{{--                                                    </option>--}}
{{--                                                </select>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                    <div class="col-md-3">
                                        <input id="constant_image" class="form-control constant_image"
                                               type="file"
                                               name="constant_image" data-id="">

                                    </div>

                                    <button type="submit" class="btn btn-success"><i
                                                class="fa fa-arrow-right"></i> حفظ
                                    </button>
                                </div>
                                {!! Form::close() !!}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="constant" id="constant" value="{{$constant_name}}">
    <input type="hidden" name="url_action" id="url_action" value="{{$url_action}}">
    <input type="hidden" name="cate_type" id="cate_type" value="{{$type}}">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet box grey-gallery ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-list"></i>
                        <span class="caption-subject bold uppercase"> {{$sub_title}}</span>
                    </div>

                </div>
                <div class="portlet-body">

                    <table class="table table-striped table-bordered table-hover table-checkable order-column"
                           id="constants_tbl">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th> صورة</th>
                            <th> اسم التصنيف</th>
                            {{--                            <th> نوع التصنيف</th>--}}
                            <th>العمليات</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>


@endsection

@section('js')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="{{url('/')}}/assets/global/scripts/datatable.js" type="text/javascript"></script>
    <script src="{{url('/')}}/assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
    <script src="{{url('/')}}/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js"
            type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL SCRIPTS -->
    <script src="{{url('/')}}/assets/global/scripts/app.min.js" type="text/javascript"></script>
    <!-- END THEME GLOBAL SCRIPTS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="{{url('/')}}/assets/pages/scripts/table-datatables-managed.min.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
    <script src="{{url('/')}}/assets/js/categories.js" type="text/javascript"></script>

@stop