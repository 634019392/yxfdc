@extends('admin.common.main')

@section('title_first', '楼盘管理')
@section('title', '楼盘列表')

@section('content')

    <div class="pd-20">
        <div class="cl pd-5 bg-1 bk-gray mt-20">
            <span class="l">
                <a href="{{ route('admin.advimgs.create') }}" class="btn btn-primary radius">
                    <i class="icon-plus"></i>
                    添加</a>
            </span>
            <span class="r">共有数据：<strong>{{ $advimgs->total() }}</strong> 条</span>
        </div>
        <table class="table table-border table-bordered table-hover table-bg table-sort">
            <thead>
            <tr class="text-c">
                <th width="10"><input type="checkbox" name="" value=""></th>
                <th width="20">ID</th>
                <th width="100">首页轮播图</th>
                <th width="10">创建时间</th>
                <th width="10">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($advimgs as $advimg)
                <tr class="text-c">
                    <td>
                        <input type="checkbox" value="{{ $advimg->id }}" name="ids[]">
                    </td>
                    <td>{{ $advimg->id }}</td>
                    <td>
                        <img src="{{ $advimg->slideshow }}" style="max-height: 100px">
                    </td>
                    <td>
                        {{ $advimg['created_at'] }}
                    </td>
                    <td class="f-14 node-manage">
                        {!! $advimg->editBtn('admin.advimgs.edit') !!}
                        {!! $advimg->destroyBtn('admin.advimgs.destroy') !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $advimgs->links() }}
    </div>

@stop

@section('js')
    <script>
        const _token = "{{ csrf_token() }}";
        // 单个删除
        $('.delbtn').click(function () {
            let _this = $(this);
            //询问框
            layer.confirm('确定是全选删除？', {
                btn: ['是的', '取消'] //按钮
            }, function (index) {
                let url = _this.attr('href');
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
                    } else {
                        layer.msg(res.msg, {time: 1000, icon: 1});
                    }
                })
            });
            return false;
        })

    </script>
@stop
