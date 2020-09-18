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

        <form action="{{ route('admin.buyers.update', $recommender) }}" method="post" class="form form-horizontal" id="fang-add">
            @csrf
            {{ method_field('put') }}
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>状态：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    @foreach($recommender_status as $status => $name)
                        @if ($status == 0)
                            @continue
                        @endif
                        <div class="radio-box">
                            <input type="radio" id="radio-{{$loop->index}}" @if($recommender->status == $status) checked @endif name="status" value="{{ $status }}">
                            <label for="radio-{{$loop->index}}">{{ $name }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-primary radius @if($recommender->status == 5) disabled @endif" type="submit" @if($recommender->status == 5) disabled = "disabled" @endif value="修改">
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

    </script>
@stop