@foreach(['success', 'danger', 'error', 'info'] as $msg)
    @if(session()->has($msg))
        <div class="Huialert Huialert-{{ $msg }}"><i class="Hui-iconfont">&#xe6a6;</i>{{ session()->get($msg) }}</div>
    @endif
@endforeach