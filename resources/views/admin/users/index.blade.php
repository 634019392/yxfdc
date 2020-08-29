@extends('admin.common.main')

@section('title', '用户列表')

@section('content')

    <div class="pd-20">
        <div class="text-c"> 日期范围：
            <input type="text" onfocus="WdatePicker({maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}'})" id="datemin" class="input-text Wdate" style="width:120px;">
            -
            <input type="text" onfocus="WdatePicker({minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d'})" id="datemax" class="input-text Wdate" style="width:120px;">
            <input type="text" class="input-text" style="width:250px" placeholder="输入会员名称、电话、邮箱" id="" name="">
            <button type="submit" class="btn btn-success" id="" name=""><i class="icon-search"></i> 搜用户</button>

        </div>
        <div class="cl pd-5 bg-1 bk-gray mt-20">
            <span class="l">
                <a href="javascript:;" onclick="deleteAll()" class="btn btn-danger radius">
                    <i class="icon-trash"></i>
                    批量删除</a>
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary radius">
                    <i class="icon-plus"></i>
                    添加用户</a>
            </span>
            <span class="r">共有数据：<strong>{{ $users->total() }}</strong> 条</span>
        </div>
        <table class="table table-border table-bordered table-hover table-bg table-sort">
            <thead>
            <tr class="text-c">
                <th width="25"><input type="checkbox" name="" value=""></th>
                <th width="50">ID</th>
                <th width="70">用户名</th>
                <th width="80">真实姓名</th>
                <th width="70">角色名称</th>
                <th width="40">性别</th>
                <th width="90">手机</th>
                <th width="150">邮箱</th>
                <th width="130">加入时间</th>
                <th width="50">状态</th>
                <th width="100">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr class="text-c">
                    <td>
                        @if(auth()->id() !== $user->id)
                            @if($user->deleted_at == null)
                                <input type="checkbox" value="{{ $user->id }}" name="ids[]">
                            @endif
                        @endif
                    </td>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->truename }}</td>
                    @if(in_array($user->role_id, $roles))
                        <td>{{ $user->role->name }}</td>
                    @else
                        <td>游客</td>
                    @endif
                    <td>{{ $user->sex }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td class="user-status"><span class="label label-success">已启用</span></td>
                    <td class="f-14 user-manage">
                        <a href="{{ route('admin.users.role', $user) }}" class="label label-secondary radius">分配角色</a>
                        {!! $user->editBtn('admin.users.edit') !!}
                        @if(auth()->id() !== $user->id)
                            @if($user->deleted_at)
                                <a href="{{ route('admin.users.restore', ['user_id' => $user->id]) }}" class="label label-warning radius">还原</a>
                            @else
                                <a href="{{ route('admin.users.destroy', ['user' => $user]) }}" class="label label-danger radius delbtn">删除</a>
                            @endif
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $users->links() }}
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
                        url: "{{ route('admin.users.delall') }}",
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
