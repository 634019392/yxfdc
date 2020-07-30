@extends('admin.common.main')

@section('title_first', '楼盘管理')
@section('title', '楼盘编辑')

@section('css')
    {{-- webuploader上传样式 --}}
    <link rel="stylesheet" type="text/css" href="/webuploader/webuploader.css"/>
@endsection

@section('content')

    <article class="page-container">

        @include('admin.common._validate')

        <form action="{{ route('admin.houses.update', $data->id) }}" method="post" class="form form-horizontal" id="form-member-add">
            @csrf
            {{method_field('put')}}
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>项目名称：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="name" value="{{ $data->name }}">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>是否是全民营销楼盘：</label>
                <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                    @if ($data->is_marketing == 0)
                        <div class="radio-box">
                            <input type="radio" id="n" name="is_marketing" value="0" checked>
                            <label for="n">否</label>
                        </div>
                        <div class="radio-box">
                            <input type="radio" id="y" name="is_marketing" value="1">
                            <label for="y">是</label>
                        </div>
                    @else
                        <div class="radio-box">
                            <input type="radio" id="n" name="is_marketing" value="0">
                            <label for="n">否</label>
                        </div>
                        <div class="radio-box">
                            <input type="radio" id="y" name="is_marketing" value="1" checked>
                            <label for="y">是</label>
                        </div>
                    @endif
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>项目封面：</label>
                <div class="formControls col-xs-2 col-sm-2">
                    <div id="picker">项目封面</div>
                </div>
                <div class="formControls col-xs-6 col-sm-7">
                    <!-- 表单提交时，上传图片地址，以#隔开 -->
                    <input type="hidden" name="image_pic" id="image_pic" data-house_id="{{ $data->id }}" value="{{ $data->img }}"/>
                    <!-- 显示上传成功后的图片容器 -->
                    <div id="imglist">
                        @if($data->img)
                            <span style="position: relative;margin-right: 30px">
                                <img src="{{ $data->img }}" style="width: 100px;height: 100px;"/>
                                <strong onclick="delpic(this, '{{ $data->img }}', 'house_img')" style="position: absolute;color: #1F1F1F;left: 110px;cursor:pointer;">X</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>项目地址：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="address" value="{{ $data->address }}">
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>项目热线：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="phone" value="{{ $data->phone }}">
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>参考价格：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="number" class="input-text" name="reference" value="{{ $data->reference }}">
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span style="font-size: x-large">配套信息</span></label>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>开盘日期：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="mating[open_time]" value="{{ $data->mating->open_time }}" />
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>产品类型：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="mating[type]" value="{{ $data->mating->type }}">
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>楼盘特色：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="mating[feature]" value="{{ $data->mating->feature }}">
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>装修情况：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="mating[decor]" value="{{ $data->mating->decor }}">
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>占地面积：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="number" class="input-text" name="mating[floor_space]" value="{{ $data->mating->floor_space }}" onchange="this.value=this.value.replace(/\D|^0/g,'')">
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>产权：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="number" class="input-text" name="mating[property_right]" value="{{ $data->mating->property_right }}" onchange="this.value=this.value.replace(/\D|^0/g,'')">
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>绿化率：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="number" class="input-text" name="mating[greening]" value="{{ $data->mating->greening }}" onInput="clearNoNum(this)">
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>容积率：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="mating[plot]" value="{{ $data->mating->plot }}" onInput="clearNoNum(this)">
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>物业名称：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="mating[property_name]" value="{{ $data->mating->property_name }}">
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>交付日期：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="mating[delivery_time]" value="{{ $data->mating->delivery_time }}" />
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>交通配套：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="mating[traffic]" value="{{ $data->mating->traffic }}">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>教育配套：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="mating[education]" value="{{ $data->mating->education }}">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>医疗配套：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="mating[medical]" value="{{ $data->mating->medical }}">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>商业配套：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="mating[business]" value="{{ $data->mating->business }}">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>其他配套：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="mating[other]" value="{{ $data->mating->other }}">
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span style="font-size: x-large">户型图</span></label>
                <input class="btn btn-success radius btn-foolr-plan" type="button" style="margin-top: 10px;margin-left: 13px" value="新增">
            </div>
            <span class="foolr_plan_list">
                @if($data->houseFloors)
                    <input type="hidden" id="add_num" value="{{ $data->houseFloors->count() }}">
                    @foreach($data->houseFloors as $k => $floor_plan)
                        <input type="hidden" name="foolr_plan[{{$k}}][id]" value="{{ $floor_plan->id }}">
                        <div class="row cl">
                            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>户型图：</label>
                            <div class="formControls col-xs-2 col-sm-2">
                                <div id="picker_{{$k}}">上传</div>
                            </div>
                            <div class="formControls col-xs-6 col-sm-7">
                                <input type="hidden" name="foolr_plan[{{$k}}][floor_plan]" id="img_url_{{$k}}" data-house_floor_id="{{ $floor_plan->id }}" value="{{ $floor_plan->floor_plan }}"/>
                                <div id="img_show_{{$k}}">
                                    @if($floor_plan->floor_plan)
                                        <span style="position: relative;margin-right: 30px">
                                            <img src="{{ $floor_plan->floor_plan }}" style="width: 100px;height: 100px;"/>
                                            <strong onclick="delimg(this, '{{ $floor_plan->floor_plan }}', '{{$k}}', 'foolr_plan_img')" style="position: absolute;color: #1F1F1F;left: 110px;cursor:pointer;">X</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row cl">
                            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>描述1：</label>
                            <div class="formControls col-xs-8 col-sm-9">
                                <input type="text" class="input-text" name="foolr_plan[{{$k}}][floor_row1]" value="{{ $floor_plan->floor_row1 }}">
                            </div>
                        </div>
                        <div class="row cl">
                            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>描述2：</label>
                            <div class="formControls col-xs-8 col-sm-9">
                                <input type="text" class="input-text" name="foolr_plan[{{$k}}][floor_row2]" value="{{ $floor_plan->floor_row2 }}">
                            </div>
                        </div>
                        <div class="row cl">
                            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>描述3：</label>
                            <div class="formControls col-xs-8 col-sm-9">
                                <input type="text" class="input-text" name="foolr_plan[{{$k}}][floor_row3]" value="{{ $floor_plan->floor_row2 }}">
                            </div>
                        </div>
                    @endforeach
                @endif
            </span>

            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-primary radius" type="submit" style="margin-top: 10%" value="修改">
                </div>
            </div>
        </form>
    </article>

@stop

@section('js')
    <!-- webuploader上传js -->
    <script type="text/javascript" src="/webuploader/webuploader.js"></script>

    <script>
        // 编辑页面已存在的户型图，在页面准备阶段实例化这些户型图的上传插件
        $(document).ready(function () {
            var num = $('#add_num').val();
            for (i = 0; i < num; i++) {
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
                        _token: '{{csrf_token()}}',
                        num: i
                    },
                    // 文件上传是的表单名称
                    fileVal: 'file',
                    // 选择文件的按钮
                    pick: {
                        id: '#picker_' + i,
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
                    let num = ret.num;
                    // 隐藏域传值
                    let obj = $('#img_url_' + num);
                    obj.val(src);
                    // img渲染图片
                    let imglist = $('#img_show_' + num);
                    let html = `
            <span style="position: relative;margin-right: 30px">
                <img src="${ret.url}" style="width: 100px;height: 100px;" />
                <strong onclick="delimg(this, '${ret.url}', '${num}', 'foolr_plan_img')" style="position: absolute;color: #1F1F1F;left: 110px;cursor:pointer;">X</strong>
            </span>
            `;
                    imglist.append(html);
                });
            }

        });


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

//        //手机号验证
//        jQuery.validator.addMethod("iphone", function (value, element) {
//            var reg = /^(\+86-|%(\s{0}))?1[3-9]\d{9}$/;
//            return this.optional(element) || (reg.test(value));
//        }, "请正确填写您的手机号码");


        // 这个是楼盘封面的初始化上传按钮
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

        // 楼盘主体信息的
        // del_img: house_img
        function delpic(obj, url, del_img) {
            let picObj = $('#image_pic');
            let info = {
                _token: '{{csrf_token()}}',
                url: url,
                del_img: del_img,
                house_id: picObj.data('house_id')
            };
            $.ajax({
                url: "{{ route('admin.delfilesql') }}",
                type: 'post',
                data: info,
                success: function (ret) {
                    $(obj).parent('span').remove();
                    // 替换后的值
                    let picReplace = picObj.val().replace(url, '');
                    // 覆盖原值
                    picObj.val(picReplace);
                }
            })
        }

        // 户型图的
        // del_img: foolr_plan_img
        function delimg(obj, url, num, del_img) {
            let picObj = $('#img_url_' + num);
            let info = {
                _token: '{{csrf_token()}}',
                url: url,
                del_img: del_img,
                house_floor_id: picObj.data('house_floor_id')
            };
            $.ajax({
                url: "{{ route('admin.delfilesql') }}",
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
        });

    </script>
@stop