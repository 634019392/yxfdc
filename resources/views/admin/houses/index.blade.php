@extends('admin.common.main')

@section('title_first', '楼盘管理')
@section('title', '楼盘列表')

@section('content')

    <div class="pd-20">
        <div class="text-c"> 搜索楼盘：
            <form action="{{ route('admin.houses.index') }}" method="get">
                <input type="text" class="input-text" style="width:250px" value="{{ request()->get('kw') }}" placeholder="输入楼盘名称" id="" name="kw">
                <button type="submit" class="btn btn-success"><i class="icon-search"></i> 搜楼盘名称</button>
            </form>
        </div>
        <div class="cl pd-5 bg-1 bk-gray mt-20">
            <span class="l">
                <a href="javascript:;" onclick="deleteAll()" class="btn btn-danger radius">
                    <i class="icon-trash"></i>
                    批量删除</a>
                <a href="{{ route('admin.houses.create') }}" class="btn btn-primary radius">
                    <i class="icon-plus"></i>
                    添加</a>
            </span>
            <span class="r">共有数据：<strong>{{ count($houses) }}</strong> 条</span>
        </div>
        <table class="table table-border table-bordered table-hover table-bg table-sort">
            <thead>
            <tr class="text-c">
                <th width="10"><input type="checkbox" name="" value=""></th>
                <th width="20">ID</th>
                <th width="100">项目名称</th>
                <th width="10">是否开启<br>全民营销</th>
                <th width="100">项目地址</th>
                <th width="70">封面图片</th>
                <th width="30">热线</th>
                <th width="10">参考价格<br>（元/㎡）</th>
                <th width="10">创建时间</th>
                <th width="10">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($houses as $house)
                <tr class="text-c">
                    <td>
                        <input type="checkbox" value="{{ $house['id'] }}" name="ids[]">
                    </td>
                    <td>{{ $house['id'] }}</td>
                    <td>
                        {{ $house['name'] }}
                    </td>
                    <td>
                        @if($house['is_marketing'] == 1)
                            <span class="label label-success radius">是</span>
                        @else
                            <span class="label radius">否</span>
                        @endif
                    </td>
                    <td>
                        {{ $house['address'] }}
                    </td>
                    <td>
                        <img src="{{ $house['img'] }}" style="max-height: 100px">
                    </td>
                    <td>
                        {{ $house['phone'] }}
                    </td>
                    <td>
                        {{ $house['reference'] }}
                    </td>
                    <td>
                        {{ $house['created_at'] }}
                    </td>
                    <td class="f-14 node-manage">
                        {!! $house->editBtn('admin.houses.edit') !!}
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
                        {{--url: "{{ route('admin.houses.delall') }}",--}}
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
