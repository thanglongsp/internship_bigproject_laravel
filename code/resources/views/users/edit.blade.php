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
                    <label for="inputName" class="col-sm-2 col-form-label">Họ tên:</label>
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
                    <label for="birthday" class="col-sm-2 col-form-label">Ngày sinh:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="birthday" name="birthday" value="{{ date('m/d/Y', strtotime(Auth::user()->birthday)) }}"><!--validate cho trường này do đổi type-->
                    </div>
                </div>
                <div class="form-group row">
                    <label for="phone-number" class="col-sm-2 col-form-label">Số điện thoại</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="phone_number" placeholder="Số điện thoại" value="{{ Auth::user()->phone_number }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Mật khẩu:</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="inputPassword" placeholder="Password">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Nhập lại mật khẩu:</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="inputPassword_confirmation" placeholder="Re-enter password">
                    </div>
                </div> 
                <div class="form-group row">
                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-primary">
                            Lưu chỉnh sửa
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