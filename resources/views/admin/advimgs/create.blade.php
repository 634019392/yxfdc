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

        <form action="{{ route('admin.advimgs.store') }}" method="post" class="form form-horizontal" id="form-member-add">
            @csrf
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>七牛裁图模式：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <select class="select valid" name="mode" size="1" aria-required="true" aria-invalid="false">
                        <option value="0">0.限定缩略图的长边最多为w，短边最多为h，进行等比缩放，不裁剪。如果只指定 w 参数则表示限定长边（短边自适应），只指定 h 参数则表示限定短边（长边自适应）。</option>
                        <option value="1">1.限定缩略图的宽最少为w，高最少为h，进行等比缩放，居中裁剪。转后的缩略图通常恰好是 设置值 的大小（有一个边缩放的时候会因为超出矩形框而被裁剪掉多余部分）。如果只指定 w 参数或只指定 h 参数，代表限定为长宽相等的正方图。</option>
                        <option value="2" selected>2.	限定缩略图的宽最多为w，高最多为h，进行等比缩放，不裁剪。如果只指定 w 参数则表示限定宽（高自适应），只指定 h 参数则表示限定高（宽自适应）。它和模式0类似，区别只是限定宽和高，不是限定长边和短边。从应用场景来说，模式0适合移动设备上做缩略图，模式2适合PC上做缩略图。</option>
                        <option value="3">3.限定缩略图的宽最少为w，高最少为h，进行等比缩放，不裁剪。如果只指定 w 参数或只指定 h 参数，代表长宽限定为同样的值。你可以理解为模式1是模式3的结果再做居中裁剪得到的。</option>
                        <option value="4">4.限定缩略图的长边最少为w，短边最少为h，进行等比缩放，不裁剪。如果只指定 w 参数或只指定 h 参数，表示长边短边限定为同样的值。这个模式很适合在手持设备做图片的全屏查看（把这里的长边短边分别设为手机屏幕的分辨率即可），生成的图片尺寸刚好充满整个屏幕（某一个边可能会超出屏幕）。</option>
                        <option value="5">5.限定缩略图的长边最少为w，短边最少为h，进行等比缩放，居中裁剪。如果只指定 w 参数或只指定 h 参数，表示长边短边限定为同样的值。同上模式4，但超出限定的矩形部分会被裁剪。</option>
                    </select>
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>图片宽：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="width" value="{{ old('width') }}">
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>图片高：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="height" value="{{ old('height') }}">
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>轮播图：</label>
                <div class="formControls col-xs-2 col-sm-2">
                    <div id="picker">上传</div>
                </div>
                <div class="formControls col-xs-6 col-sm-7">
                    <!-- 表单提交时，上传图片地址，以#隔开 -->
                    <input type="hidden" name="slideshow" id="image_pic"/>
                    <!-- 显示上传成功后的图片容器 -->
                    <div id="imglist"></div>
                </div>
            </div>

            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-primary radius" type="submit" style="margin-top: 10%" value="添加">
                </div>
            </div>
        </form>
    </article>

@stop

@section('js')
    <!-- webuploader上传js -->
    <script type="text/javascript" src="/webuploader/webuploader.js"></script>

    <script>
        // 单选框的样式
        $('.skin-minimal input').iCheck({
            checkboxClass: 'icheckbox-blue',
            radioClass: 'iradio-blue',
            increaseArea: '20%'
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


        // 初始化Web Uploader
        var uploader = WebUploader.create({
            // 选完文件后，是否自动上传
            auto: true,
            // swf文件路径
            swf: '/webuploader/Uploader.swf',
            // 文件接收服务端 上传PHP的代码
            server: '{{ route('admin.upfile') }}',
            // 文件上传是携带参数
            formData: {
                _token: '{{csrf_token()}}'
            },
            // 文件上传是的表单名称
            fileVal: 'file',
            // 选择文件的按钮
            pick: {
                id: '#picker',
                // 是否开启选择多个文件的能力
                multiple: false
            },
            // 压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
            resize: true
        });
        // 上传成功时的回调方法
        uploader.on('uploadSuccess', function (file, ret) {
            // 图片路径
            let src = ret.url;
            $('#image_pic').val(src);

            let imglist = $('#imglist');
            let html = `
            <span style="position: relative;margin-right: 30px">
                <img src="${ret.url}" style="width: 100px;height: 100px;" />
                <strong onclick="delpic(this, '${ret.url}')" style="position: absolute;color: #1F1F1F;left: 110px;cursor:pointer;">X</strong>
            </span>
            `;
            imglist.append(html);
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