@extends('admin.common.main')

@section('title', '角色列表')

@section('content')

    <div class="pd-20">
        <div class="text-c"> 搜索角色：
            <form action="{{ route('admin.roles.index') }}" method="get">
                <input type="text" class="input-text" style="width:250px" value="{{ $kw }}" placeholder="输入角色名称" id="" name="kw">
                <button type="submit" class="btn btn-success"><i class="icon-search"></i> 搜角色名称</button>
            </form>
        </div>
        <div class="cl pd-5 bg-1 bk-gray mt-20">
            <span class="l">
                <a href="javascript:;" onclick="deleteAll()" class="btn btn-danger radius">
                    <i class="icon-trash"></i>
                    批量删除</a>
                <a href="{{ route('admin.roles.create') }}" class="btn btn-primary radius">
                    <i class="icon-plus"></i>
                    添加角色</a>
            </span>
            <span class="r">共有数据：<strong>{{ $roles->total() }}</strong> 条</span>
        </div>
        <table class="table table-border table-bordered table-hover table-bg table-sort">
            <thead>
            <tr class="text-c">
                <th width="25"><input type="checkbox" name="" value=""></th>
                <th width="80">ID</th>
                <th width="100">角色名称</th>
                <th width="70">查看权限</th>
                <th width="100">创建时间</th>
                <th width="100">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($roles as $role)
                <tr class="text-c">
                    <td>
                        @if (!$role->deleted_at)
                            <input type="checkbox" value="{{ $role->id }}" name="ids[]">
                        @endif
                    </td>
                    <td>{{ $role->id }}</td>
                    <td>{{ $role->name }}</td>
                    <td class="role-status">
                        <a href="{{ route('admin.roles.node', $role) }}" class="label label-success radius">权限</a>
                    </td>
                    <td>{{ $role->created_at }}</td>
                    <td class="f-14 role-manage">
                        @if ($role->deleted_at)
                            <a href="{{ route('admin.roles.restore', ['role_id' => $role]) }}" class="label label-warning radius">还原</a>
                        @else
                            <a href="{{ route('admin.roles.edit', $role) }}" class="label label-secondary radius">编辑</a>
                            <a href="{{ route('admin.roles.destroy', ['role' => $role]) }}" class="label label-danger radius delbtn">删除</a>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $roles->links() }}
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
                        url: "{{ route('admin.roles.delall') }}",
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
