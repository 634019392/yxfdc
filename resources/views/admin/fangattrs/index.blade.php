@extends('admin.common.main')

@section('title', '权限列表')

@section('content')

    <div class="pd-20">
        <div class="text-c"> 搜索权限：
            <form action="{{ route('admin.fangattrs.index') }}" method="get">
                <input type="text" class="input-text" style="width:250px" value="{{ request()->get('kw') }}" placeholder="输入权限名称" id="" name="kw">
                <button type="submit" class="btn btn-success"><i class="icon-search"></i> 搜权限名称</button>
            </form>
        </div>
        <div class="cl pd-5 bg-1 bk-gray mt-20">
            <span class="l">
                <a href="javascript:;" onclick="deleteAll()" class="btn btn-danger radius">
                    <i class="icon-trash"></i>
                    批量删除</a>
                <a href="{{ route('admin.fangattrs.create') }}" class="btn btn-primary radius">
                    <i class="icon-plus"></i>
                    添加权限</a>
            </span>
            <span class="r">共有数据：<strong>{{ count($fangattrs) }}</strong> 条</span>
        </div>
        <table class="table table-border table-bordered table-hover table-bg table-sort">
            <thead>
            <tr class="text-c">
                <th width="25"><input type="checkbox" name="" value=""></th>
                <th width="80">ID</th>
                <th width="100">权限名称</th>
                <th width="70">路由别名</th>
                <th width="70">是否菜单</th>
                <th width="100">创建时间</th>
                <th width="100">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($fangattrs as $fangattr)
                <tr class="text-c">
                    <td>
                        <input type="checkbox" value="{{ $fangattr['id'] }}" name="ids[]">
                    </td>
                    <td>{{ $fangattr['id'] }}</td>
                    <td class="text-l">{{ $fangattr['html'] }}{{ $fangattr['name'] }}</td>
                    <td>{{ $fangattr['route_name'] }}</td>
                    {{--<td>{!! $fangattr->menu !!}</td>--}}
                    <td>
                        @if($fangattr['is_menu'])
                            <span class="label label-success radius">是</span>
                        @else
                            <span class="label label-danger radius">否</span>
                        @endif
                    </td>
                    <td>{{ $fangattr['created_at'] }}</td>
                    <td class="f-14 node-manage">
                        <a href="{{ route('admin.fangattrs.edit', $fangattr['id']) }}" class="label label-secondary radius">编辑</a>
                        <a href="{{ route('admin.fangattrs.destroy', ['node' => $fangattr['id']]) }}" class="label label-danger radius delbtn">删除</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
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
            }, function (index) {
                let ck_dom = $('input[name="ids[]"]:checked');
                let ids = [];
                ck_dom.each((key, value) => {
                    ids.push($(value).val())
                });

                if (ids.length > 0) {
                    $.ajax({
                        {{--url: "{{ route('admin.fangattrs.delall') }}",--}}
                        type: 'delete',
                        data: {ids: ids, _token: _token},
                    }).then(res => {
                        if (res.status === 0) {
                            layer.msg(res.msg, {time: 1000, icon: 1});
                            location.reload();
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
