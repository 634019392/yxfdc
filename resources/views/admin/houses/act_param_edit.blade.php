@extends('admin.common.main')

@section('title_first', '全民营销')

@section('title', '编辑')

@section('css')
    {{-- webuploader上传样式 --}}
    <link rel="stylesheet" type="text/css" href="/webuploader/webuploader.css"/>
    <style>
        .fang-style {
            padding-bottom: 10px;
        }
    </style>
@endsection

@section('content')

    <article class="page-container">

        @include('admin.common._validate')

        <form action="{{ route('admin.houses.act_param.update', $actParam) }}" method="post" class="form form-horizontal" id="fang-add">
            @csrf
            {{ method_field('put') }}
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"></label>
                <div class="formControls col-xs-8 col-sm-9">
                    <h3>楼盘名称:  {{ $actParam->house->name }}</h3>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>是否需要审核：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <div class="radio-box">
                        <input type="radio" id="is_check-1" onclick="is_show(1)" name="is_check" value="1" @if($actParam->is_check) checked @endif />
                        <label for="is_check-1">是</label>
                    </div>
                    <div class="radio-box">
                        <input type="radio" id="is_check-0" onclick="is_show(0)" name="is_check" value="0" @if(!$actParam->is_check) checked @endif />
                        <label for="is_check-0">否</label>
                    </div>
                </div>
            </div>
            <div class="row cl info-check-day">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>审核天数：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="number" placeholder="默认天数" class="input-text radius size-M" value="{{$actParam->check_day}}" name="check_day">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>推荐费文字说明：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" placeholder="例如：(1万含税)" class="input-text radius size-M" name="fee_text" value="{{$actParam->fee_text}}">
                </div>
            </div>
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-primary radius" type="submit" value="修改">
                </div>
            </div>
        </form>
    </article>

@stop

@section('js')
    <!-- webuploader上传js -->
    <script type="text/javascript" src="/webuploader/webuploader.js"></script>

    <script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
    <script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/validate-methods.js"></script>
    <script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/messages_zh.js"></script>
    <!-- 配置文件 -->
    <script type="text/javascript" src="/ueditor/ueditor.config.js"></script>
    <!-- 编辑器源码文件 -->
    <script type="text/javascript" src="/ueditor/ueditor.all.js"></script>
    <script>
        $(document).ready(function () {
            var is_check = parseInt("{{$actParam->is_check}}");
            is_show(is_check)
        });

        function is_show(res) {
            if (res === 1) {
                $('.info-check-day').show();
            } else {
                $('.info-check-day').hide();
                $("input[name=check_day]").val(0);
            }
        }
    </script>
@stop