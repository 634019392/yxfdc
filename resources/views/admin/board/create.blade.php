@extends('admin.common.main')

@section('title_first', '广告管理')
@section('title', '添加')

@section('css')
    {{-- webuploader上传样式 --}}
    <link rel="stylesheet" type="text/css" href="/webuploader/webuploader.css"/>
@endsection

@section('content')

    <article class="page-container">

        @include('admin.common._validate')

        <form enctype="multipart/form-data" action="{{ route('admin.boards.store') }}" method="post" class="form form-horizontal" id="form-member-add">
            @csrf
            {{--<div class="row cl">--}}
                {{--<label class="form-label col-xs-4 col-sm-3"><span class="c-red">* </span>调用链接模式：</label>--}}
                {{--<div class="formControls col-xs-8 col-sm-9">--}}
                    {{--<select onchange="pat_fun()" class="select valid pat-opt" name="status" size="1" aria-required="true" aria-invalid="false">--}}
                        {{--<option value="0">请选择链接模式</option>--}}
                        {{--<option value="1">1.使用内部链接</option>--}}
                        {{--<option value="2">2.微信公众号永久素材</option>--}}
                    {{--</select>--}}
                {{--</div>--}}
            {{--</div>--}}

            {{--<div class="row cl url">--}}
                {{--<label class="form-label col-xs-4 col-sm-3"><span class="c-red">* </span>url：</label>--}}
                {{--<div class="formControls col-xs-8 col-sm-9">--}}
                    {{--<input type="text" class="input-text" name="url">--}}
                {{--</div>--}}
            {{--</div>--}}

            <div class="row cl title">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">* </span>文章标题：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="title">
                </div>
            </div>

            <div class="row cl cover_img">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">* </span>封面图片：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="file" class="input-text" name="cover_img">
                </div>
            </div>

            <div class="row cl digest">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">* </span>文章摘要：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="digest">
                </div>
            </div>

            <div class="row cl content">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">* </span>文章内容：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <!-- 加载编辑器的容器 -->
                    <script id="content" name="content" type="text/plain">这里写你的初始化内容</script>
                </div>
            </div>

            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-primary radius submit-btn" type="submit" style="margin-top: 10%" value="添加">
                </div>
            </div>
        </form>
    </article>

@stop

@section('js')
    <!-- 配置文件 -->
    <script type="text/javascript" src="/ueditor/ueditor.config.js"></script>
    <!-- 编辑器源码文件 -->
    <script type="text/javascript" src="/ueditor/ueditor.all.js"></script>

    <script>
        <!-- 实例化编辑器,以id为准 -->
        var ue = UE.getEditor('content');

        function pat_fun() {
            var option = $('.pat-opt option:selected');
            var pat_val = option.val()
            if (pat_val == 1) {
                $('.url').show();
                $('.title').hide();
                $('.content').hide();
            }
            if (pat_val == 2) {
                $('.url').hide();
                $('.title').show();
                $('.content').show();
            }
        }

        $('.submit-btn').on('click', function () {
            if ($('.pat-opt option:selected').val() == 0) {
                alert('请选择链接模式');
                return false;
            } else {
                return true;
            }
        });

        // 表单验证
        // https://www.runoob.com/jquery/jquery-plugin-validate.html
        $('#form-member-add').validate({
            rules: {
                slideshow: {
                    "required": true,
                    "maxlength": 50
                },
            },
            onkeyup: false,
            success: "valid",
            submitHandler: function (form) {
                form.submit();
            }
        });

        function delpic(obj, url) {
            let info = {
                _token: '{{csrf_token()}}',
                url: url
            };
            let picObj = $('#image_pic');
            $.ajax({
                url: "{{ route('admin.delfile') }}",
                type: 'post',
                data: info,
                success: function (ret) {
                    $(obj).parent('span').remove();
                    // 覆盖原值
                    picObj.val('');
                }
            })
        }


    </script>
@stop