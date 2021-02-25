@extends('admin.common.main')

@section('title_first', '房源管理')
@section('title', '房源列表')

@section('content')

    <div class="pd-20">
        <div class="text-c"> 日期范围：
            <input type="text" onfocus="WdatePicker({maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}'})" id="datemin" class="input-text Wdate" style="width:120px;">
            -
            <input type="text" onfocus="WdatePicker({minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d'})" id="datemax" class="input-text Wdate" style="width:120px;">
            <input type="text" class="input-text" style="width:250px" placeholder="输入会员名称、电话、邮箱" id="" name="">
            <button type="submit" class="btn btn-success" id="" name=""><i class="icon-search"></i> 搜房源</button>

        </div>
        <div class="cl pd-5 bg-1 bk-gray mt-20">
            <span class="l">
                <a href="javascript:;" onclick="deleteAll()" class="btn btn-danger radius">
                    <i class="icon-trash"></i>
                    批量删除</a>
                <a href="{{ route('admin.fangs.create') }}" class="btn btn-primary radius">
                    <i class="icon-plus"></i>
                    添加</a>
                <a href="#" class="btn btn-primary radius">
                    <i class="icon-plus"></i>
                    导出成Excel</a>
            </span>
            <span class="r">共有数据：<strong>{{ $fangs->total() }}</strong> 条</span>
        </div>
        <table class="table table-border table-bordered table-hover table-bg table-sort">
            <thead>
            <tr class="text-c">
                <th width="25"><input type="checkbox" name="" value=""></th>
                <th width="30">ID</th>
                <th width="100">房源名称</th>
                <th width="100">小区名称</th>
                <th width="150">小区地址</th>
                <th width="40">租赁方式</th>
                <th width="90">业主（房东）</th>
                <th width="50">租金</th>
                <th width="40">朝向</th>
                <th width="40">出租状态</th>
                <th width="150">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($fangs as $fang)
                <tr class="text-c">
                    <td>
                        <input type="checkbox" value="{{ $fang->id }}" name="ids[]">
                    </td>
                    <td>{{ $fang->id }}</td>
                    <td>{{ $fang->fang_name }}</td>
                    <td>{{ $fang->fang_xiaoqu }}</td>
                    <td>{{ $fang->fang_addr }}</td>
                    <td>{{ $fang->fang_rent_class }}</td>
                    <td>{{ $fang->fang_owner }}</td>
                    <td>{{ $fang->fang_rent }}</td>
                    <td>{{ $fang->fang_direction }}</td>
                    <td>
                        @if($fang->fang_status == 0)
                            <span data-id="{{ $fang->id }}" onclick="changeFangStatus(this, {{ $fang->id }}, 1)" class="label label-success radius" style="cursor: pointer;">
                                未租
                            </span>
                        @else
                            <span data-id="{{ $fang->id }}" onclick="changeFangStatus(this, {{ $fang->id }}, 0)" class="label label-danger radius" style="cursor: pointer;">
                                已租
                            </span>
                        @endif
                    </td>
                    <td class="f-14 user-manage">
                        <a onclick="layer_show('查看照片','{{ route('admin.fangs.show',$fang) }}',800,500)" class="label label-warning radius">查看身份证照片</a>
                        {!! $fang->editBtn('admin.fangs.edit') !!}
                        {!! $fang->deleteBtn('admin.fangs.destroy') !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $fangs->appends(Request::except('page'))->links() }}
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
                        url: "{{ route('admin.fangs.delall') }}",
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
                    //layer.close(index);
                }

            });
        }


        // 更改是否已租
        function changeFangStatus(obj, id, fang_status) {
            let info = {id, fang_status, _token: _token};
            $.ajax({
                url: "{{ route('admin.fangs.changestatus') }}",
                type: 'patch',
                data: info,
                success: function (ret) {
                    $(obj).toggleClass('label-success label-danger').html(ret.msg);
                }
            })
        }
    </script>
@stop
