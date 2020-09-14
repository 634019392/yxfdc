@extends('admin.common.main')

@section('title_first', '全民营销')
@section('title', '客户列表')

@section('content')

    <div class="pd-20">
        <div class="text-c"> 搜索客户手机号：
            <form action="{{ route('admin.buyers.index') }}" method="get">
                <input type="text" class="input-text" style="width:250px" value="{{ request()->get('kw') }}" placeholder="输入客户手机号" name="kw">
                <button type="submit" class="btn btn-success"><i class="icon-search"></i> 搜索</button>
            </form>
        </div>
        <div class="cl pd-5 bg-1 bk-gray mt-20">
            {{--<span class="l">--}}
            {{--<a href="javascript:;" onclick="deleteAll()" class="btn btn-danger radius">--}}
            {{--<i class="icon-trash"></i>--}}
            {{--批量删除</a>--}}
            {{--</span>--}}

            {{--点击导出excel为模态框start--}}
            <button class="btn radius btn-primary" onClick="modaldemo()">导出excel</button>
            <div id="excel-demo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content radius">
                        <div class="modal-header">
                            <h3 class="modal-title">选择导出日期</h3>
                            <a class="close" data-dismiss="modal" aria-hidden="true" href="javascript:void();">×</a>
                        </div>
                        <div class="modal-body">
                            <p>
                                开始时间：<input type="text" name="start_time" onfocus="WdatePicker({maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}'})" id="datemin" class="input-text Wdate" style="width:120px;">
                                -------
                                结束时间：<input type="text" name="end_time" onfocus="WdatePicker({minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d'})" id="datemax" class="input-text Wdate" style="width:120px;">

                        </div>
                        <div class="modal-footer">
                            <button onclick="download_excel()" class="btn btn-primary">确定</button>
                            <button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
                        </div>
                    </div>
                </div>
            </div>
            {{--点击导出excel为模态框end--}}

            <span class="r">共有数据：<strong>{{ count($buyers) }}</strong> 条</span>
        </div>
        <table class="table table-border table-bordered table-hover table-bg table-sort">
            <thead>
            <tr class="text-c">
                {{--<th width="10"><input type="checkbox" name="" value=""></th>--}}
                <th width="20">ID</th>
                <th width="50">经纪人</th>
                <th width="50">经纪人手机号</th>
                <th width="80">经纪人身份证号码</th>
                <th width="100">推荐项目名称</th>
                <th width="50">客户</th>
                <th width="50">客户手机号</th>
                <th width="20">客户年龄</th>
                <th width="15">客户性别</th>
                <th width="40">客户身份证后6位</th>
                <th width="20">状态</th>
                <th width="10">创建时间</th>
                <th width="10">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($buyers as $buyer)
                <tr class="text-c">
                    {{--<td>--}}
                    {{--<input type="checkbox" value="{{ $buyer['id'] }}" name="ids[]">--}}
                    {{--</td>--}}
                    <td>{{ $buyer['id'] }}</td>
                    <td>
                        {{ $buyer->apiuser->truename }}
                    </td>
                    <td>
                        {{ $buyer->apiuser->phone }}
                    </td>
                    <td>
                        {{ $buyer->apiuser->id_card }}
                    </td>
                    <td>
                        @if($buyer->house)
                            {{ $buyer->house->name }}
                        @else
                            <span class="label label-danger radius">无信息</span>
                        @endif
                    </td>
                    <td>
                        {{ $buyer->buyer->truename }}
                    </td>
                    <td>
                        {{ $buyer->buyer->phone }}
                    </td>
                    <td>
                        {{ $buyer->buyer->age }}
                    </td>
                    <td>
                        {{ $buyer->buyer->sex }}
                    </td>
                    <td>
                        {{ $buyer->buyer->card_alert_six }}
                    </td>
                    <td>
                        @switch($buyer['status_arr'][0])
                            @case(1)
                            <span class="label label-default radius">{{ $buyer['status_arr'][1] }}</span>
                            @break

                            @case(2)
                            <span class="label label-secondary radius">{{ $buyer['status_arr'][1] }}</span>
                            @break

                            @case(3)
                            <span class="label label-success radius">{{ $buyer['status_arr'][1] }}</span>
                            @break

                            @case(4)
                            <span class="label label-warning radius">{{ $buyer['status_arr'][1] }}</span>
                            @break

                            @case(5)
                            <span class="label label-danger radius">{{ $buyer['status_arr'][1] }}</span>
                            @break

                            @default
                            <span class="label label-default radius">{{ $buyer['status_arr'][1] }}</span>
                        @endswitch
                    </td>
                    <td>
                        {{ $buyer->created_at }}
                    </td>
                    <td>
                        {!! $buyer->editBtn('admin.buyers.edit') !!}
                        {!! $buyer->atWillBtn('admin.buyers.tail') !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $buyers->appends(Request::except('page'))->links() }}
    </div>

@stop

@section('js')
    <script>
        const _token = "{{ csrf_token() }}";

        // 导出excel模态框
        function modaldemo() {
            $("#excel-demo").modal("show");
        }

        // 导出
        function download_excel() {
            var start_time = $("input[name=start_time]").val();
            var end_time = $("input[name=end_time]").val();
            var info = {start_time, end_time, _token: _token};
            $.ajax({
                type: 'post',
                data: info,
                url: "{{route('admin.buyers.export')}}",
                success: function (res) {
                    if (res.status === 0) {
                        window.open(res.down_url)
                    } else {
                        layer.msg('没有此操作权限', {time: 1000})
                    }
                    $("#excel-demo").modal("hide");
                }
            })
        }

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
                    if (res.status_arr === 0) {
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
                        if (res.status_arr === 0) {
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
