@extends('admin.common.main')

@section('title', '文章列表')

@section('content')

    <div class="pd-20">
        <form method="get" class="text-c" onsubmit="return dopost()">
            <input type="text" onfocus="WdatePicker({maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}'})" id="datemin" class="input-text Wdate" style="width:120px;">
            -
            <input type="text" onfocus="WdatePicker({minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d'})" id="datemax" class="input-text Wdate" style="width:120px;">
            文章标题：
            <input type="text" class="input-text" style="width:250px" placeholder="标题" id="title">
            <button type="submit" class="btn btn-success"><i class="icon-search"></i> 搜索</button>
        </form>
        <div class="cl pd-5 bg-1 bk-gray mt-20">
            <span class="l">
                <a href="javascript:;" onclick="deleteAll()" class="btn btn-danger radius">
                    <i class="icon-trash"></i>
                    批量删除</a>
                <a href="{{ route('admin.articles.create') }}" class="btn btn-primary radius">
                    <i class="icon-plus"></i>
                    添加文章</a>
            </span>
            {{--<span class="r">共有数据：<strong></strong> 条</span>--}}
        </div>
        <table class="table table-border table-bordered table-hover table-bg table-sort articles_example display">
            <thead>
            <tr class="text-c">
                {{--<th width="25"><input type="checkbox" name="" value=""></th>--}}
                <th width="30">ID</th>
                <th width="50">标题</th>
                <th width="50">摘要</th>
                <th width="70">封面</th>
                <th width="70">内容</th>
                <th width="100">创建时间</th>
                <th width="100">操作</th>
            </tr>
            </thead>
        </table>
    </div>

@stop

@section('js')
    <script>
        const _token = "{{ csrf_token() }}";

        var dataTable = $('.articles_example').DataTable({
            // 隐藏搜索
            searching: false,
            columnDefs: [
                {targets: [6], orderable: false},
            ],
            // 开启服务器模式
            serverSide: true,
            // ajax发起请求
            ajax: {
                // 请求地址
                url: "{{ route('admin.articles.index') }}",
                // 请求方式 get/post
                type: 'get',
                // 头信信息 laravel post请求时 csrf
                {{--headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},--}}
                // 请求的参数
                data: function (ret) {
                    ret.datemin = $('#datemin').val();
                    ret.datemax = $('#datemax').val();
                    ret.title = $('#title').val();
                },
            },
            // columns要对tr中的td单元格中的内容进行数据填充
            // 注意：如果data接收类似a或b的信息，实际服务器没有返回该信息，那么一定要同时设置 defaultContent属性，否则报错
            columns: [
                // 总的数量与表格的列的数量一致，不多也不少
                // 字段名称与sql查询出来的字段时要保持一致，就是服务器返回数据对应的字段名称
                // defaultContent 和 className 可选参数
                {'data': 'id', 'className': 'text-c'},
                {'data': 'title', 'className': 'text-c'},
                {'data': 'desn', 'className': 'text-c'},
                {'data': 'pic', 'className': 'text-c'},
                {'data': 'body', 'className': 'text-c'},
                {'data': 'created_at', 'className': 'text-c'},
                {'data': 'action', "defaultContent": "编辑或添加", 'className': 'text-c'},
            ],
            /*
            如果上面 {'data': 'action', "defaultContent": "编辑", 'className': 'text-c'},中不是追加字段action,则默认显示回调函数的编辑和删除按钮
            创建tr/td时的回调函数，可以继续修改、优化tr/td的显示，里边有遍历效果，会依次扫描生成的每个tr
            row:创建好的tr的dom对象
            data:数据源，代表服务器端返回的每条记录的实体信息
            dataIndex:数据源的索引号码
            */
//                createdRow: function (row, data, dataIndex) {
//                    var id = data.id;
//                    var html = `
//                    <a href="/admin/articles/${id}/edit" class="label label-secondary radius">编辑</a>
//                    <a href="/admin/articles/${id}" class="label label-danger radius delbtn">删除</a>
//                    `;
//                    $(row).find('td:last-child').html(html)
//                }
        });

        // 表单提交
        function dopost() {
            // 手动调用一次dataTable插件请求
            dataTable.ajax.reload();
            // 取消表单默认行为
            return false;
        }
    </script>
@stop
