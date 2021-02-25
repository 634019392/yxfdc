@extends('admin.common.main')

@section('title_first', '广告管理')
@section('title', '公众号文章采集')

@section('css')
    {{-- webuploader上传样式 --}}
    <link rel="stylesheet" type="text/css" href="/webuploader/webuploader.css"/>
    {{--1.屏蔽table样式(带缩略...)--}}
    {{--<style>--}}
    {{--table{--}}
    {{--width:100%;--}}
    {{--table-layout:fixed;/* 只有定义了表格的布局算法为fixed，下面td的定义才能起作用。 */--}}
    {{--}--}}
    {{--.table tbody tr td{--}}
    {{--width:100%;--}}
    {{--word-break:keep-all;/* 不换行 */--}}
    {{--white-space:nowrap;/* 不换行 */--}}
    {{--overflow:hidden;/* 内容超出宽度时隐藏超出部分的内容 */--}}
    {{--text-overflow:ellipsis;/* 当对象内文本溢出时显示省略标记(...) ；需与overflow:hidden;一起使用。*/--}}
    {{--}--}}
    {{--.table tbody tr td img{--}}
    {{--width:5em;--}}
    {{--}--}}
    {{--</style>--}}
@endsection

@section('content')

    <article class="page-container">

        @include('admin.common._validate')

        <form enctype="multipart/form-data" action="{{ route('admin.boards.store') }}" method="post" class="form form-horizontal" id="form-member-add">
            @csrf

            <div class="row cl title">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">* </span>一键采集：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input class="btn btn-success radius" type="button" onclick="wechat_gather()" value="采集">
                </div>
            </div>
            <div class="row cl title">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red"></span>采集内容：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <textarea class="c_cont" name="" id="" cols="130" rows="10" style="overflow:scroll;overflow-x:hidden;"></textarea>
                </div>
            </div>

            {{--<div class="row cl title">--}}
            {{--<label class="form-label col-xs-4 col-sm-3"><span class="c-red">* </span>起始值：</label>--}}
            {{--<div class="formControls col-xs-8 col-sm-9">--}}
            {{--<input type="text" placeholder="起始值" class="input-text radius size-MINI" value="0">--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<div class="row cl title">--}}
            {{--<label class="form-label col-xs-4 col-sm-3"><span class="c-red">* </span>列表数量：</label>--}}
            {{--<div class="formControls col-xs-8 col-sm-9">--}}
            {{--<input type="text" placeholder="列表数量" class="input-text radius size-MINI" value="20">--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--2.屏蔽table(带缩略...)--}}
            {{--<div class="row cl title">--}}
            {{--<table class="table table-border table-bg table-bordered table-hover">--}}
            {{--<thead>--}}
            {{--<tr>--}}
            {{--<th>media_id</th>--}}
            {{--<th>标题</th>--}}
            {{--<th>封面图</th>--}}
            {{--<th>内容</th>--}}
            {{--<th>状态</th>--}}
            {{--</tr>--}}
            {{--</thead>--}}
            {{--<tbody>--}}
            {{--<tr>--}}
            {{--<td>media_id</td>--}}
            {{--<td>.active</td>--}}
            {{--<td>--}}
            {{--<img src="https://ss1.bdstatic.com/70cFuXSh_Q1YnxGkpoWK1HF6hhy/it/u=1593106255,4245861836&fm=26&gp=0.jpg" alt="">--}}
            {{--</td>--}}
            {{--<td>悬停在行</td>--}}
            {{--<td>入库入库成功</td>--}}
            {{--</tr>--}}
            {{--<tr>--}}
            {{--<td>media_id</td>--}}
            {{--<td>.警告或出错警告或出错警告或出错警告或出错警告或出错警告或出错警告或出错警告或出错警告或出错警告或123出错</td>--}}
            {{--<td>入库成功或积极</td>--}}
            {{--<td>入库成功或积极</td>--}}
            {{--<td>入库入库成功</td>--}}
            {{--</tr>--}}
            {{--<tr>--}}
            {{--<td>media_id</td>--}}
            {{--<td>.warning</td>--}}
            {{--<td>警告或出错</td>--}}
            {{--<td class="test">警告或出错警告或出错警告或出错警告或出错警告或出错警告或出错警告或出错警告或出错警告或出错警告或123出错</td>--}}
            {{--<td>入库入库成功</td>--}}
            {{--</tr>--}}
            {{--<tr>--}}
            {{--<td>警告或出错警告或出错警告或出错警告或出错警告或出错警告或出错警告或出错警告或出错警告或出错警告或123出错11111111111111111111111111111111111111111111111111</td>--}}
            {{--<td>.danger</td>--}}
            {{--<td>危险</td>--}}
            {{--<td>危险</td>--}}
            {{--<td>入库入库成功</td>--}}
            {{--</tr>--}}
            {{--</tbody>--}}
            {{--</table>--}}
            {{--</div>--}}

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

            {{--<div class="row cl title">--}}
            {{--<label class="form-label col-xs-4 col-sm-3"><span class="c-red">* </span>文章标题：</label>--}}
            {{--<div class="formControls col-xs-8 col-sm-9">--}}
            {{--<input type="text" class="input-text" name="title">--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--<div class="row cl cover_img">--}}
            {{--<label class="form-label col-xs-4 col-sm-3"><span class="c-red">* </span>封面图片：</label>--}}
            {{--<div class="formControls col-xs-8 col-sm-9">--}}
            {{--<input type="file" class="input-text" name="cover_img">--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--<div class="row cl digest">--}}
            {{--<label class="form-label col-xs-4 col-sm-3"><span class="c-red">* </span>文章摘要：</label>--}}
            {{--<div class="formControls col-xs-8 col-sm-9">--}}
            {{--<input type="text" class="input-text" name="digest">--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--<div class="row cl content">--}}
            {{--<label class="form-label col-xs-4 col-sm-3"><span class="c-red">* </span>文章内容：</label>--}}
            {{--<div class="formControls col-xs-8 col-sm-9">--}}
            {{--<!-- 加载编辑器的容器 -->--}}
            {{--<script id="content" name="content" type="text/plain">这里写你的初始化内容</script>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--<div class="row cl">--}}
            {{--<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">--}}
            {{--<input class="btn btn-primary radius submit-btn" type="submit" style="margin-top: 10%" value="添加">--}}
            {{--</div>--}}
            {{--</div>--}}
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
        //        var ue = UE.getEditor('content');


        function wechat_gather() {
            var info = {
                _token: "{{ csrf_token() }}"
            };
            var start_num = 0;
            var page = 1;
            for (var i = 0; i < page; i++) {
                info.start_num = start_num;
//                console.log(i);
                $.ajax({
                    async: false,
                    url: "{{ route('admin.boards.wechat_gather') }}",
                    type: 'post',
                    data: info,
                    success: function (ret) {
                        page = ret.page;
                        start_num = ret.start_num;
                        console.log(ret);
                        $.map(ret.result.item, function (v, key) {
                            console.log(v);
                            var media_id = v.media_id;
                            var title = v.content.news_item[0].title;
                            var old_str = $('.c_cont').val();
                            var id = v.id;
                            var status_msg = v.status_msg;
                            var str = 'id:'+id+';---media_id:'+media_id+';---标题:'+title+';---状态:'+status_msg+'\r\n';
                            var new_str = old_str + str;
                            $('.c_cont').val(new_str);
                            $('.c_cont').scrollTop($('.c_cont')[0].scrollHeight)
                        });

                    },
                    error: function (error) {
                        console.log(error);
                        setTimeout(function () {
                            wechat_gather();
                        }, 5000);
                    }
                });
            }
        }

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