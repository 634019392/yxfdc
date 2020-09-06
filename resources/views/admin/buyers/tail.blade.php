@extends('admin.common.main')

@section('title_first', '全民营销')

@section('title', '跟踪客户（客户记录）')

@section('css')
    {{-- webuploader上传样式 --}}
    <link rel="stylesheet" type="text/css" href="/webuploader/webuploader.css"/>
    <style>
        .fang-style {
            padding-bottom: 10px;
        }
    </style>
@endsection

@section('content')

    <article class="page-container">
        @include('admin.common._validate')
        {{--<div class="row cl">--}}
        {{--<label class="form-label col-xs-4 col-sm-3"><span style="font-size: x-large">客户记录</span></label>--}}
        {{--<input class="btn btn-success radius btn-foolr-plan" type="button" style="margin: 15px;margin-left: 13px" value="新增">--}}
        {{--</div>--}}
        <a class="btn btn-primary radius" href="{{ route('admin.buyers.index') }}">
            返回客户列表
        </a>

        @if(!empty($client_records->count()))
            <div class="panel-body">
                <table class="table table-border table-bordered radius table-bg mt-20">
                    <thead>
                    <tr class="text-c">
                        <th width="50">记录id</th>
                        <th width="100">跟踪方式</th>
                        <th>跟踪详情</th>
                        <th width="200">创建时间</th>
                        <th width="80">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($client_records as $val)
                        <tr class="text-c">
                            <th>{{ $val->id }}</th>
                            <th>{{ $val->text }}</th>
                            <td>{{ $val->desc }}</td>
                            <td>{{ $val->created_at }}</td>
                            <td>{!! $val->atWillModal('admin.buyers.tail_edit') !!}</td>
                            {{--模态框 start--}}
                            <div id="modal-demo{{$val->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content radius">
                                        <div class="modal-header">
                                            <h3 class="modal-title">客户记录-id：{{ $val->id }}</h3>
                                            <a class="close" data-dismiss="modal" aria-hidden="true" href="javascript:void();">×</a>
                                        </div>
                                        <form action="{{ route('admin.buyers.tail_update', $val) }}" method="post" class="form form-horizontal">
                                            @csrf
                                            @method('put')
                                            <div class="modal-body">
                                                <div class="row cl">
                                                    <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>跟踪方式：</label>
                                                    <div class="formControls col-xs-8 col-sm-9">
                                                        <input class="input-text radius" value="{{ $val->text }}" name="text" type="text" placeholder="例如：电话跟进、现场来访、微信跟进等"/>
                                                    </div>
                                                </div>
                                                <div class="row cl">
                                                    <label class="form-label col-xs-4 col-sm-3"><span class="c-red"></span>客户记录：</label>
                                                    <div class="formControls col-xs-8 col-sm-9">
                                                        <input class="input-text radius" value="{{ $val->desc }}" name="desc" type="text" placeholder="例如：10.1国庆回，持续跟进中。"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-primary">保存</button>
                                                <button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            {{--模态框 end--}}
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        {{--<hr style="border:1px dashed #666666; margin: 10px">--}}
        <form action="{{ route('admin.buyers.tail_create', $recommender) }}" method="post" class="form form-horizontal">
            @csrf
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>跟踪方式：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input class="input-text radius" name="text" type="text" placeholder="例如：电话跟进、现场来访、微信跟进等"/>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red"></span>客户记录：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input class="input-text radius" name="desc" type="text" placeholder="例如：10.1国庆回，持续跟进中。"/>
                </div>
            </div>
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-success radius" type="submit" value="新增/保存">
                </div>
            </div>
        </form>
    </article>
@stop

@section('js')
    <!-- webuploader上传js -->
    <script type="text/javascript" src="/webuploader/webuploader.js"></script>

    <script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
    <script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/validate-methods.js"></script>
    <script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/messages_zh.js"></script>
    <!-- 配置文件 -->
    <script type="text/javascript" src="/ueditor/ueditor.config.js"></script>
    <!-- 编辑器源码文件 -->
    <script type="text/javascript" src="/ueditor/ueditor.all.js"></script>
    <script>
        $('.at-will-modal').click(function () {
            var id = $(this).data('id');
            $('#modal-demo' + id).modal('show')
        });
    </script>
@stop