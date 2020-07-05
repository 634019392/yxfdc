@extends('admin.common.main')

@section('title_first', '房东管理')

@section('title', '房东添加')

@section('css')
    {{-- webuploader上传样式 --}}
    <link rel="stylesheet" type="text/css" href="/webuploader/webuploader.css"/>
@endsection

@section('content')

    <article class="page-container">

        @include('admin.common._validate')

        <form action="{{ route('admin.fangowners.store') }}" method="post" class="form form-horizontal" id="form-member-add">
            @csrf
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>姓名：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" id="name" name="name" value="{{ old('name') }}">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>性别：</label>
                <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                    <div class="radio-box">
                        <input type="radio" id="man" name="sex" value="男" checked>
                        <label for="man">男</label>
                    </div>
                    <div class="radio-box">
                        <input type="radio" id="woman" name="sex" value="女">
                        <label for="woman">女</label>
                    </div>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red"></span>年龄：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{ old('age') }}" placeholder="" id="age" name="age">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>手机：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" id="phone" name="phone" placeholder="" value="{{ old('phone') }}">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>邮箱：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="email" class="input-text" placeholder="123@google.cn" name="email" id="email" value="{{ old('email') }}">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>身份证号码：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" id="card" name="card" value="{{ old('card') }}">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red"></span>家庭地址：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" id="address" name="address" value="{{ old('address') }}">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>身份证照片：</label>
                <div class="formControls col-xs-2 col-sm-2">
                    <div id="picker">上传图片</div>
                    <div>正面 反面 手持</div>
                </div>
                <div class="formControls col-xs-6 col-sm-7">
                    <!-- 表单提交时，上传图片，以#隔开 -->
                    <input type="hidden" name="pic" id="pic">
                    <!-- 显示上传成功后的图片容器 -->
                    <div id="imglist"></div>
                </div>
            </div>
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-primary radius" type="submit" value="添加">
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
                name: {
                    "required": true,
                    "maxlength": 50
                },
                phone: {
                    "required": true,
                    "maxlength": 50
                },
                email: {
                    "required": true,
                    "maxlength": 50
                },
                card: {
                    "required": true,
                    "maxlength": 50
                },
            },
            onkeyup: false,
            success: "valid",
            submitHandler: function (form) {
                form.submit();
            }
        })

        // 手机号验证
        jQuery.validator.addMethod("iphone", function (value, element) {
            var reg = /^(\+86-|%(\s{0}))?1[3-9]\d{9}$/;
            return this.optional(element) || (reg.test(value));
        }, "请正确填写您的手机号码");

        // 初始化Web Uploader
        var uploader = WebUploader.create({
            // 选完文件后，是否自动上传
            auto: true,
            // swf文件路径
            swf: '/webuploader/Uploader.swf',
            // 文件接收服务端 上传PHP的代码
            server: '{{ route('admin.fangowners.upfile') }}',
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
                multiple: true
            },
            // 压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
            resize: true
        });
        // 上传成功时的回调方法
        uploader.on('uploadSuccess', function (file, ret) {
            // 图片路径
            let src = ret.url;
            // 上传图片，以#隔开
            let val = $('#pic').val();
            let tmp = val + '#' + src;
            $('#pic').val(tmp);

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
                url: url
            };
            let picObj = $('#pic');
            $.ajax({
                url: "{{ route('admin.fangowners.delfile') }}",
                type: 'get',
                data: info,
                success: function (ret) {
                    $(obj).parent('span').remove();
                    // 替换后的值
                    let picReplace = picObj.val().replace('#'+url, '');
                    // 覆盖原值
                    picObj.val(picReplace);
                }
            })
        }
    </script>
@stop