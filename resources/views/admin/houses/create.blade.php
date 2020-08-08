@extends('admin.common.main')

@section('title_first', '楼盘管理')
@section('title', '楼盘添加')

@section('css')
    {{-- webuploader上传样式 --}}
    <link rel="stylesheet" type="text/css" href="/webuploader/webuploader.css"/>
@endsection

@section('content')

    <article class="page-container">

        @include('admin.common._validate')

        <form action="{{ route('admin.houses.store') }}" method="post" class="form form-horizontal" id="form-member-add">
            @csrf
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>项目名称：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="name" value="{{ old('name') }}">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>是否是全民营销楼盘：</label>
                <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                    <div class="radio-box">
                        <input type="radio" id="n" name="is_marketing" value="0" checked>
                        <label for="n">否</label>
                    </div>
                    <div class="radio-box">
                        <input type="radio" id="y" name="is_marketing" value="1">
                        <label for="y">是</label>
                    </div>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>项目封面：</label>
                <div class="formControls col-xs-2 col-sm-2">
                    <div id="picker">项目封面</div>
                </div>
                <div class="formControls col-xs-6 col-sm-7">
                    <!-- 表单提交时，上传图片地址，以#隔开 -->
                    <input type="hidden" name="image_pic" id="image_pic"/>
                    <!-- 显示上传成功后的图片容器 -->
                    <div id="imglist"></div>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>项目地址：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="address" value="{{ old('address') }}">
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>项目热线：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="phone" value="{{ old('phone') }}">
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>参考价格：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="number" class="input-text" name="reference" value="{{ old('reference') }}">
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>标签(以#分割,最多2个#,也就是3个标签)：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="tag" value="{{ old('tag') }}">
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span style="font-size: x-large">配套信息</span></label>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>开盘日期：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="mating[open_time]" value="{{ old('open_time') }}">
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>产品类型：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="mating[type]" value="{{ old('type') }}">
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>楼盘特色：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="mating[feature]" value="{{ old('feature') }}">
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>装修情况：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="mating[decor]" value="{{ old('decor') }}">
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>占地面积：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="number" class="input-text" name="mating[floor_space]" value="{{ old('floor_space') }}" onchange="this.value=this.value.replace(/\D|^0/g,'')">
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>建筑面积：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="number" class="input-text" name="mating[covered_area]" value="{{ old('covered_area') }}" onchange="this.value=this.value.replace(/\D|^0/g,'')">
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>产权：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="number" class="input-text" name="mating[property_right]" value="{{ old('property_right') }}" onchange="this.value=this.value.replace(/\D|^0/g,'')">
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>绿化率：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="number" class="input-text" name="mating[greening]" value="{{ old('greening') }}" onInput="clearNoNum(this)">
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>容积率：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="mating[plot]" value="{{ old('plot') }}" onInput="clearNoNum(this)">
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>物业名称：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="mating[property_name]" value="{{ old('property_name') }}">
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>交付日期：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="mating[delivery_time]" value="{{ old('delivery_time') }}">
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>交通配套：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="mating[traffic]" value="{{ old('traffic') }}">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>教育配套：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="mating[education]" value="{{ old('education') }}">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>医疗配套：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="mating[medical]" value="{{ old('medical') }}">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>商业配套：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="mating[business]" value="{{ old('business') }}">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>其他配套：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="mating[other]" value="{{ old('other') }}">
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span style="font-size: x-large">户型图</span></label>
                <input class="btn btn-success radius btn-foolr-plan" type="button" style="margin-top: 10px;margin-left: 13px" value="新增">
            </div>
            <input type="hidden" id="add_num" value="0">
            <span class="foolr_plan_list"></span>

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

        function clearNoNum(obj) {
            //先把非数字的都替换掉，除了数字和.
            obj.value = obj.value.replace(/[^\d.]/g, "");
            //必须保证第一个为数字而不是.
            obj.value = obj.value.replace(/^\./g, "");
            //保证只有出现一个.而没有多个.
            obj.value = obj.value.replace(/\.{2,}/g, ".");
            //保证.只出现一次，而不能出现两次以上
            obj.value = obj.value.replace(".", "$#$").replace(/\./g, "").replace("$#$", ".");
            //保证 数字整数位不大于8位
            if (100000000 <= parseFloat(obj.value))
                obj.value = "";
        }

        // 表单验证
        // https://www.runoob.com/jquery/jquery-plugin-validate.html
        $('#form-member-add').validate({
            rules: {
                name: {
                    "required": true,
                    "maxlength": 50
                },
                address: {
                    "required": true,
                    "maxlength": 50
                },
                image_pic: {
                    "required": true,
                    "maxlength": 50
                },
                phone: {
                    "required": true,
//                    "iphone": true,
                    "maxlength": 15
                },
                "mating[open_time]": {
                    "required": true,
                    "maxlength": 50
                },
                "mating[floor_space]": {
                    "required": true,
                    "maxlength": 50
                },
                "mating[property_right]": {
                    "required": true,
                    "maxlength": 50
                },
                "mating[greening]": {
                    "required": true,
                    "maxlength": 50
                },
                "mating[plot]": {
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

        // 手机号验证
        //        jQuery.validator.addMethod("iphone", function (value, element) {
        //            var reg = /^(\+86-|%(\s{0}))?1[3-9]\d{9}$/;
        //            return this.optional(element) || (reg.test(value));
        //        }, "请正确填写您的手机号码");


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

        $('.btn-foolr-plan').click(function (ret) {
            let obj = $('#add_num');
            let num = obj.val();
            obj.val(parseInt(num) + 1);

            let html = `
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>户型图：</label>
                <div class="formControls col-xs-2 col-sm-2">
                    <div id="picker_${num}">上传</div>
                </div>
                <div class="formControls col-xs-6 col-sm-7">
                    <input type="hidden" name="foolr_plan[${num}][floor_plan]" id="img_url_${num}"/>
                    <div id="img_show_${num}"></div>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>描述1：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="foolr_plan[${num}][floor_row1]" value="{{ old('row1') }}">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>描述2：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="foolr_plan[${num}][floor_row2]" value="{{ old('row2') }}">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>描述3：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="foolr_plan[${num}][floor_row3]" value="{{ old('row3') }}">
                </div>
            </div>
            `;
            $('.foolr_plan_list').append(html);

            // 初始化Web Uploader
            var uploader_ = WebUploader.create({
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
                    id: '#picker_' + num,
                    // 是否开启选择多个文件的能力
                    multiple: false
                },
                // 压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
                resize: true
            });

            // 上传成功时的回调方法
            uploader_.on('uploadSuccess', function (file, ret) {
                // 图片路径
                let src = ret.url;
                // 隐藏域传值
                let obj = $('#img_url_' + num);
                obj.val(src);
                // img渲染图片
                let imglist = $('#img_show_' + num);
                let html = `
            <span style="position: relative;margin-right: 30px">
                <img src="${ret.url}" style="width: 100px;height: 100px;" />
                <strong onclick="delimg(this, '${ret.url}', '${num}')" style="position: absolute;color: #1F1F1F;left: 110px;cursor:pointer;">X</strong>
            </span>
            `;
                imglist.append(html);
            });
        })

        function delimg(obj, url, num) {
            let info = {
                _token: '{{csrf_token()}}',
                url: url
            };
            let picObj = $('#img_url_' + num);
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