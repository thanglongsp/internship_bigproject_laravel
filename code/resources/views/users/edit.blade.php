@extends('layouts.master')

@section('content')
<div class="container">
    <form method="post" action="{{route('users.update',Auth::user()->id)}}" enctype="multipart/form-data">
        @csrf
        <input name="_method" type="hidden" value="PUT">     
        <div class="row mt-5">
            <div class="col-sm-3"> 
                <div class="card">
                    <input type="hidden" name="new_name" id="new_name" value="{{Auth::user()->avatar}}">
                     <img id="img_avatar" class="card-img-top" src="{{asset('images/avatars/'.Auth::user()->avatar)}}" alt="Card image cap" style="padding: 6px">
                    <div class="card-body">
                        <input accept="image/*" name="avatar" title="Đổi ảnh đại diện" type="file" id="avatar"  onchange="reupAvatar()">
                    </div>
                </div>
            <button class="btn btn-primary" href="{{route('users.show', Auth::id())}}">Back</button>

            </div> 
            
            <div class="col-sm-9">
                <div class="form-group row"> 
                    <label for="inputName" class="col-sm-2 col-form-label">Name :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="inputName" placeholder="Họ tên" value="{{ Auth::user()->name }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputEmail" class="col-sm-2 col-form-label">Email:</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" name="inputEmail" placeholder="Email" value="{{ Auth::user()->email }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="birthday" class="col-sm-2 col-form-label">Birth day :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="birthday" name="birthday" value="{{ date('m/d/Y', strtotime(Auth::user()->birthday)) }}"><!--validate cho trường này do đổi type-->
                    </div>
                </div>
                <div class="form-group row"> 
                    <label for="inputGender" class="col-sm-2 col-form-label">Gender :</label>
                    <div class="col-sm-10">
                        @if(Auth::user()->gender == 1)
                            <input type="radio" name ="inputGender" value="1" checked>Male</input>
                            <input type="radio" name ="inputGender" value="2">Female</input>
                        @endif
                        @if(Auth::user()->gender == 2)
                            <input type="radio" name ="inputGender" value="1">Male </input>
                            <input type="radio" name ="inputGender" value="2" checked>Female</input>
                        @endif 
                    </div>
                </div>
                <div class="form-group row">
                    <label for="phone-number" class="col-sm-2 col-form-label">Phone number :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="phone_number" placeholder="phone number" value="{{ Auth::user()->phone_number }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Password :</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="inputPassword" placeholder="Password">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Confirm password :</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="inputPassword_confirmation" placeholder="Re-enter password">
                    </div>
                </div>
                </br> 
                <div class="form-group row">
                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-primary">
                            Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

</div>
@endsection