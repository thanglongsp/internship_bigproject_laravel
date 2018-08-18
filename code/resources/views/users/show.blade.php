@extends('users.profile')
@section('content2')
<div>
   {{--  <h3>Thông tin người dùng </h3>
    <br> --}}
    <div class=".col-s-3">
        <p><strong>Họ tên : </strong> {{ $user->name }}</p>
        @if($user->gender == 1)
        <p><strong>Giới tính :</strong> Nam</p>
        @else
        <p><strong>Giới tính :</strong> Nữ</p>
        @endif
        <p><strong>Số điện thoại :</strong> {{ $user->phone_number }}</p>
        <p><strong>Ngày sinh :</strong> {{ date('m/d/Y', strtotime($user->birthday)) }}</p>
        <p><strong>Email :</strong> {{ $user->email }}</p>
    </div>  
</div>
{{-- lmao --}}
@endsection