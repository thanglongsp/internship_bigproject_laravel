@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row mt-5">
        <div class="col-sm-3">
            <div class="card">
                @if($user->id != Auth::id())
                <img class="card-img-top" src="{{asset('images/avatars/'.$user->avatar)}}" alt="Card image cap" style="padding: 6px">
                <ul class="list-group list-group-flush nav nav-pills">
                    <li class="list-group-item"><a href="{{route('users.show',$user->id)}}">Hồ sơ người dùng</a></li>
                    <li class="list-group-item"><a href="/users/{{$user->id}}/my-plans">Kế hoạch của người dùng</a></li>
                    <li class="list-group-item"><a href="/users/{{$user->id}}/my-following-plans">Kế hoạch theo dõi</a></li>
                    <li class="list-group-item"><a href="/users/{{$user->id}}/my-joined-plans">Kế hoạch tham gia</a></li>
                </ul>
                @else
                <img class="card-img-top" src="{{asset('images/avatars/'. Auth::user()->avatar)}}" alt="Card image cap" style="padding: 6px">
                <ul class="list-group list-group-flush nav nav-pills">
                    <li class="list-group-item"><a href="{{route('users.show',Auth::user()->id)}}">Hồ sơ của tôi</a></li>
                    <li class="list-group-item"><a href="/users/{{Auth::user()->id}}/my-plans">Kế hoạch của tôi</a></li>
                    <li class="list-group-item"><a href="/users/{{Auth::user()->id}}/my-following-plans">Kế hoạch tôi theo dõi</a></li>
                    <li class="list-group-item"><a href="/users/{{Auth::user()->id}}/my-joined-plans">Kế hoạch tôi tham gia</a></li>
                    <li class="list-group-item"><a href="{{route('users.edit',Auth::user()->id)}}">Chỉnh sửa trang cá nhân</a></li>
                </ul>
                @endif
            </div>
        </div>
        <div class="col-sm-9">
		    @yield('content2')
        </div>
    </div>
</div>
@endsection