@extends('admin.common.main')

@section('title', '文章编辑')

@section('css')
    <!--引入CSS-->
    <link rel="stylesheet" type="text/css" href="/webuploader/webuploader.css">
@stop

@section('content')

    <article class="page-container">

        @include('admin.common._validate')

        <form action="{{ route('admin.articles.update', $article) }}" method="post" class="form form-horizontal">
            {{ method_field('PUT') }}
            @csrf
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">* </span>文章标题：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="title" value="{{ $article->title }}">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">* </span>文章摘要：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="desn" value="{{ $article->desn }}">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">* </span>封面图片：</label>
                <div class="formControls col-xs-4 col-sm-5">
                    <div id="picker">选择文件</div>
                    <input type="hidden" id="pic" name="pic">
                </div>
                <div class="col-xs-4 col-sm-4">
                    <img src="{{ $article->pic }}" id="img" style="max-height: 100px;">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">* </span>文章内容：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <!-- 加载编辑器的容器 -->
                    <script id="body" name="body" type="text/plain">{!! $article->body !!}</script>
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
    <!--引入JS-->
    <script type="text/javascript" src="/webuploader/webuploader.js"></script>
    <!-- 配置文件 -->
    <script type="text/javascript" src="/ueditor/ueditor.config.js"></script>
    <!-- 编辑器源码文件 -->
    <script type="text/javascript" src="/ueditor/ueditor.all.js"></script>
    <!-- 实例化编辑器 -->
    <script type="text/javascript">
        // 百度富文本编辑器
        var ue = UE.getEditor('body', {
            initialFrameHeight: 200,
        });

        // 初始化Web Uploader
        var uploader = WebUploader.create({
            // 选完文件后，是否自动上传。
            auto: true,
            // swf文件路径
            swf: '/webuploader/Uploader.swf',
            // 文件接收服务端。
            server: "{{ route('admin.articles.upfile') }}",
            // 选择文件的按钮。可选。
            // 内部根据当前运行是创建，可能是input元素，也可能是flash.
            pick: {
                // 指定上传按钮
                id: '#picker',
                // 是否开启多文件上传
                multiple: false
            },
            // 文件上传是的表单名称
            fileVal: 'file',
            // 上传图片时候附加参数
            formData: {
                _token: "{{ csrf_token() }}"
            },
            // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
            resize: false
        });

        // 图片上传成功，隐藏域存值和显示上传的图片
        uploader.on('uploadSuccess', function (file, response) {
            let src = response.url;
            $('#pic').val(src);
            $('#img').attr('src', src);
        })
    </script>
@stop