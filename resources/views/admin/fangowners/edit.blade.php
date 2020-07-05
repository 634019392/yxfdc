@extends('admin.common.main')

@section('title', '用户编辑')

@section('content')

    <article class="page-container">

        @include('admin.common._validate')

        <form action="{{ route('admin.users.update', $user->id) }}" method="post" class="form form-horizontal" id="form-member-add">
            {{ method_field('PUT') }}
            {{ csrf_field() }}
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>用户：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" disabled value="{{ $user->username }}">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>原密码：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="password" class="input-text" id="spassword" name="spassword">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red"></span>新密码：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="password" class="input-text" id="password" name="password">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red"></span>确认密码：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="password" class="input-text" name="password_confirmation">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>真实姓名：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{ $user->truename }}" placeholder="" id="truename" name="truename">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>性别：</label>
                <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                    <div class="radio-box">
                        <input type="radio" id="man" name="sex" value="先生" @if($user->sex == '先生')checked
                                @endif>
                        <label for="man">先生</label>
                    </div>
                    <div class="radio-box">
                        <input type="radio" id="woman" name="sex" value="女士"@if($user->sex == '女士')checked
                                @endif>
                        <label for="woman">女士</label>
                    </div>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>手机：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" id="phone" name="phone" value="{{ $user->phone }}">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>邮箱：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="email" class="input-text" placeholder="123@google.cn" name="email" id="email" value="{{ $user->email }}">
                </div>
            </div>
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-primary radius" type="submit" value="修改用户">
                </div>
            </div>
        </form>
    </article>

@stop

@section('js')
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
                username: {
                    "required": true,
                    "maxlength": 50
                },
                truename: {
                    "required": true,
                    "maxlength": 50
                },
                password: {
                    "maxlength": 50
                },
                password_confirmation: {
                    equalTo: "#password"
                },
                phone: {
                    "required": true,
                    "iphone": true,
                    "maxlength": 15
                },
                email: {
                    "required": true,
                    email: true
                }
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
    </script>
@stop