@extends('admin.common.main')

@section('title', '用户列表')

@section('content')

    <article class="page-container">
        @include('admin.common._validate')

        <form action="{{ route('admin.users.role',$user) }}" method="post">
            @csrf

            @foreach($roleAll as $item)
                <div>
                    <label>{{ $item->name }}
                        <input type="radio" name="role_id" value="{{ $item->id }}"
                               @if($item->id == $user->role_id) checked @endif
                        >
                    </label>
                </div>
            @endforeach

            <button type="submit">给用户指定角色</button>

        </form>
    </article>
@stop
