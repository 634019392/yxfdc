@extends('admin.common.main')

@section('title_first', '房东管理')
@section('title', '房东列表')

@section('content')

    <div class="pd-20">
        <div class="text-c"> 日期范围：
            <input type="text" onfocus="WdatePicker({maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}'})" id="datemin" class="input-text Wdate" style="width:120px;">
            -
            <input type="text" onfocus="WdatePicker({minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d'})" id="datemax" class="input-text Wdate" style="width:120px;">
            <input type="text" class="input-text" style="width:250px" placeholder="输入会员名称、电话、邮箱" id="" name="">
            <button type="submit" class="btn btn-success" id="" name=""><i class="icon-search"></i> 搜房东</button>

        </div>
        <div class="cl pd-5 bg-1 bk-gray mt-20">
            <span class="l">
                <a href="javascript:;" onclick="deleteAll()" class="btn btn-danger radius">
                    <i class="icon-trash"></i>
                    批量删除</a>
                <a href="{{ route('admin.fangowners.create') }}" class="btn btn-primary radius">
                    <i class="icon-plus"></i>
                    添加</a>
                <a href="{{ route('admin.fangowners.export') }}" class="btn btn-primary radius">
                    <i class="icon-plus"></i>
                    导出成Excel</a>
            </span>
            <span class="r">共有数据：<strong>{{ $fangowners->total() }}</strong> 条</span>
        </div>
        <table class="table table-border table-bordered table-hover table-bg table-sort">
            <thead>
            <tr class="text-c">
                <th width="25"><input type="checkbox" name="" value=""></th>
                <th width="30">ID</th>
                <th width="40">房东姓名</th>
                <th width="10">性别</th>
                <th width="20">年龄</th>
                <th width="70">手机号码</th>
                <th width="90">身份证号码</th>
                <th width="150">家庭住址</th>
                <th width="50">邮箱</th>
                <th width="100">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($fangowners as $fangowner)
                <tr class="text-c">
                    <td>
                        <input type="checkbox" value="{{ $fangowner->id }}" name="ids[]">
                    </td>
                    <td>{{ $fangowner->id }}</td>
                    <td>{{ $fangowner->name }}</td>
                    <td>{{ $fangowner->sex }}</td>
                    <td>{{ $fangowner->age }}</td>
                    <td>{{ $fangowner->phone }}</td>
                    <td>{{ $fangowner->card }}</td>
                    <td>{{ $fangowner->address }}</td>
                    <td>{{ $fangowner->email }}</td>
                    <td class="f-14 user-manage">
                        <a onclick="layer_show('查看照片','{{ route('admin.fangowners.show',$fangowner) }}',800,500)" class="label label-warning radius">查看身份证照片</a>
                        <!-- 此处编辑未完善-->
                        {{--{!! $fangowner->editBtn('admin.fangowners.edit') !!}--}}
                        <!-- 此处编辑未完善End-->
                        {!! $fangowner->deleteBtn('admin.fangowners.destroy') !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $fangowners->links() }}
    </div>

@stop

@section('js')
    <script>
        const _token = "{{ csrf_token() }}";
        // 单个删除
        $('.delbtn').click(function () {
            let url = $(this).attr('href');
            $.ajax({
                url: url,
                type: 'delete',
                data: {_token: _token}
            }).then(res => {
                if (res.status === 0) {
                    layer.msg(res.msg, {time: 1000, icon: 1}, () => {
//                        $(this).parents('tr').remove()
                        window.location.reload()
                    });
                }
            })
            return false;
        })

        // 全选删除
        function deleteAll() {
            //询问框
            layer.confirm('确定是全选删除？', {
                btn: ['是的', '取消'] //按钮
            }, function () {
                let ck_dom = $('input[name="ids[]"]:checked');
                let ids = [];
                ck_dom.each((key, value) => {
                    ids.push($(value).val())
                });

                if (ids.length > 0) {
                    $.ajax({
                        url: "{{ route('admin.fangowners.delall') }}",
                        type: 'delete',
                        data: {ids: ids, _token: _token},
                    }).then(res => {
                        if (res.status === 0) {
                            layer.msg(res.msg, {time: 1000, icon: 1}, () => {
                                location.reload();
                            });
                        }
                    })
                } else {
                    layer.msg('请选择最少一条', {time: 1000})
                    layer.close(index);
                }

            });


        }
    </script>
@stop
