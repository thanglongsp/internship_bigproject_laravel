<!-- khi hoạt động thành công thì đây sẽ là blade show 10 người dùng mới nhất 
khi đó hãy đổi tên blade -->
<!--Đây là trang show tất cả các kế hoạch-->
@extends('layouts.master')

@section('content')
@include('layouts.slider')
<div class="container-fluid">
    <div class='row'>
        <div class='col-sm-2'>
            <div class="card"> 
                <div class="card-header">
                    You can see :
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><a href="{{action('PageController@index')}}">10 new plans</a></li>
                    <li class="list-group-item"><a href="{{action('PageController@hottestPlans')}}">10 hot plans</a></li>
                    <li class="list-group-item"><a href="{{action('PageController@latestUsers')}}">10 new users</a></li>
                </ul>
            </div>
        </div>
        <div class='col-sm-10'>
            @foreach($users as $user)
            <div class="card">
                <div class="card-body">
                        <div class="media">
                            <img class="mr-3" src="{{asset('images/avatars/'.$user->avatar)}}" width="150px">
                            <div class="media-body">
                                <h5 class="mt-0"><a href="#">{{$user->name}}</a></h5>
                                <p>Birth day :   {{date('d/m/Y', strtotime($user->birthday))}}</p>
                                <p>Email :       {{$user->email}}</p>        
                            </div>
                        </div>
                    <a href="{{route('users.show', $user->id)}}" class="btn btn-primary mt-2">detail >></a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection