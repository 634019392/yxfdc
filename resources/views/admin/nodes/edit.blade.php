@extends('admin.common.main')

@section('title', '权限编辑')

@section('content')

    <article class="page-container">

        @include('admin.common._validate')

        <form action="{{ route('admin.nodes.update', $node) }}" method="post" class="form form-horizontal" @submit.prevent="dopost">
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">是否顶级：</label>
                <div class="formControls col-xs-8 col-sm-9"><span class="select-box">
                        <select class="select" v-model="info.pid">
                            <option value="0" selected="">===顶级===</option>
                            @foreach($pids_0 as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </span></div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>权限名称：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" v-model="info.name">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red"></span>路由别名：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" v-model="info.route_name">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>是否菜单：</label>
                <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                    <div class="radio-box">
                        <input type="radio" id="f" value="0" v-model="info.is_menu">
                        <label for="f">否菜单</label>
                    </div>
                    <div class="radio-box">
                        <input type="radio" id="t" value="1" v-model="info.is_menu">
                        <label for="t">是菜单</label>
                    </div>
                </div>
            </div>
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-primary radius" type="submit" value="添加">
                </div>
            </div>
        </form>
    </article>

@stop

@section('js')
    <script src="/js/vue.js"></script>
    <script>
        new Vue({
            el: '.page-container',
            data: {
                info: {
                    _token: "{{ csrf_token() }}",
                    pid: "{{ $node->pid }}",
                    name: "{{ $node->name }}",
                    route_name: "{{ $node->route_name }}",
                    is_menu: "{{ $node->is_menu }}"
                }
            },
            methods: {
                async dopost(evt) {
                    let url = evt.target.getAttribute('action');
                    let {status, msg} = await $.ajax({
                        url,
                        type: 'PUT',
                        data: this.info
                    });
                    if (status === 0) {
                        layer.msg(msg, {time: 1000, icon: 1}, () => {
                            location.href = "{{ route('admin.nodes.index') }}";
                        })
                    } else {
                        layer.msg(msg, {time: 1000, icon: 2});
                    }
                },

            }
        });


    </script>
@stop