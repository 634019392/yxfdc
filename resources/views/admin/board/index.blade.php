@extends('admin.common.main')

@section('title_first', '其他管理')
@section('title', '公告栏列表')

@section('css')
    <meta content="width=device-width,user-scalable=no" name="viewport">
    <style>
        .table {
            table-layout: fixed;
        }
        .content_sl {
            width: 100px;
            white-space:nowrap;
            overflow:hidden;
            text-overflow: ellipsis;
        }
    </style>

@endsection

@section('content')

    <div class="pd-20">
        <div class="cl pd-5 bg-1 bk-gray mt-20">
            <span class="l">
                <a href="{{ route('admin.boards.create') }}" class="btn btn-primary radius">
                    <i class="icon-plus"></i>
                    添加自定义文章</a>
                <a href="{{ route('admin.boards.create_news') }}" class="btn btn-primary radius">
                    <i class="icon-plus"></i>
                    采集公众号文章</a>
            </span>
            <span class="r">共有数据：<strong></strong> 条</span>
        </div>
        <table class="table table-border table-bordered table-hover table-bg table-sort">
            <thead>
            <tr class="text-c">
                <th><input type="checkbox" name="" value=""></th>
                <th>ID</th>
                <th>状态（来源）</th>
                <th>url</th>
                <th>标题</th>
                {{--<th>内容</th>--}}
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($boards as $board)
                <tr class="text-c">
                    <td>
                        <input type="checkbox" value="" name="ids[]">
                    </td>
                    <td>
                        {{ $board->id }}
                    </td>
                    <td>
                        @if($board->status == 1)
                            <span class="label label-primary radius" type="button">本地</span>
                        @else
                            <span class="label label-warning radius" type="button">采集(公众号)</span>
                        @endif
                    </td>
                    <td>
                        <a class="btn btn-secondary size-MINI radius" type="button" href="{{ $board->url }}" target="_blank">
                            查看
                        </a>
                    </td>
                    <td>
                        {{ $board->title }}
                    </td>
                    {{--<td class="content_sl">--}}
                        {{--{{$board->content}}--}}
                    {{--</td>--}}
                    <td>

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $boards->appends(Request::except('page'))->links() }}
    </div>

@stop

@section('js')
    <script type="text/javascript">
        var viewport = document.querySelector("meta[name=viewport]");
        window.setTimeout(function () {
            viewport.setAttribute('content', 'width=980, user-scalable=yes');
        }, 300);
    </script>
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
