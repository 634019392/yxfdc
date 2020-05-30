@extends('admin.common.main')

@section('title', '给角色分配权限')

@section('content')

    <article class="page-container">
        <form action="{{ route('admin.roles.node',$role) }}" method="post" class="form form-horizontal" id="form-member-add">
            @csrf
            @foreach($nodeAll as $item)
                <div>
                    <input id="node_{{ $item['id'] }}" type="checkbox" name="node_ids[]" value="{{ $item['id'] }}"
                           @if(in_array($item['id'],$nodes)) checked @endif
                    >
                    <label for="node_{{ $item['id'] }}">
                        {{ $item['html'] }}{{ $item['name'] }}
                    </label>
                </div>
            @endforeach
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-primary radius" type="submit" value="分配权限">
                </div>
            </div>
        </form>
    </article>


@stop

@section('js')
    <script>
    </script>
@stop