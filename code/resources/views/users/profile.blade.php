@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row mt-5">
        <div class="col-sm-3">
            <div class="card">
                @if($user->id != Auth::id())
                <img class="card-img-top" src="{{asset('images/avatars/'.$user->avatar)}}" alt="Card image cap" style="padding: 6px">
                <ul class="list-group list-group-flush nav nav-pills">
                    <li class="list-group-item"><a href="{{route('users.show',$user->id)}}">Profile </a></li>
                    <li class="list-group-item"><a href="/users/{{$user->id}}/my-plans">user's plan </a></li>
                    <li class="list-group-item"><a href="/users/{{$user->id}}/my-following-plans">plan following </a></li>
                    <li class="list-group-item"><a href="/users/{{$user->id}}/my-joined-plans">Plan joined </a></li>
                </ul>
                @else
                <img class="card-img-top" src="{{asset('images/avatars/'. Auth::user()->avatar)}}" alt="Card image cap" style="padding: 6px">
                <ul class="list-group list-group-flush nav nav-pills">
                    <li class="list-group-item"><a href="{{route('users.show',Auth::user()->id)}}">My profile </a></li>
                    <li class="list-group-item"><a href="/users/{{Auth::user()->id}}/my-plans">My plans</a></li>
                    <li class="list-group-item"><a href="/users/{{Auth::user()->id}}/my-following-plans">My following plans</a></li>
                    <li class="list-group-item"><a href="/users/{{Auth::user()->id}}/my-joined-plans">My joined plans</a></li>
                    <li class="list-group-item"><a href="{{route('users.edit',Auth::user()->id)}}">Edit my profile</a></li>
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