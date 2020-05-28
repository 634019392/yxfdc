@extends('admin.common.main')

@section('title', '角色添加')

@section('content')

    <article class="page-container">

        @include('admin.common._validate')

        <form action="{{ route('admin.roles.store') }}" method="post" class="form form-horizontal" id="form-member-add">
            @csrf
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>角色名称：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="name" value="{{ old('name') }}">
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
    <script>
        // 表单验证
        // https://www.runoob.com/jquery/jquery-plugin-validate.html
        $('#form-member-add').validate({
            rules: {
                name: {
                    "required": true,
                    "maxlength": 50
                },
            },
            onkeyup: false,
            success: "valid",
            submitHandler: function (form) {
                let url = $(form).attr('action');
                let data = $(form).serialize();
                $.post(url,data).then(({status,msg}) => {
                    if (status === 0) {
                        layer.msg(msg, {time:1000, icon:1});
                        location.href = "{{ route('admin.roles.index') }}";
                    } else {
                        layer.msg(msg, {time:1000, icon:2})
                    }
                })
            }
        })

    </script>
@stop