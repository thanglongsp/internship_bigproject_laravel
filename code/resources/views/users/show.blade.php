@extends('users.profile')
@section('content2')
<div>
   {{--  <h3>Thông tin người dùng </h3>
    <br> --}}
    <div class=".col-s-3">
        <table style="width:100%">
            <tr>
                <th>Họ tên</th>
                <td>{{ $user->name }}</td>
            </tr> 
            <tr>
                <th>Giới tính </th>
                @if($user->gender == 1)
                <td>Nam</td>
                @else
                <td>Nữ</td>
                @endif
            </tr>
            <tr>
                <th>Số điện thoại </th>
                <td>{{ $user->phone_number }}</td>
            </tr>
            <tr>
                <th>Ngày sinh </th>
                <td>{{ date('m/d/Y', strtotime($user->birthday)) }}</td>
            </tr>
            <tr>
                <th>Email </th>
                <td>{{ $user->email }}</td>
            </tr>
        </table>
    </div>  
</div>
{{-- lmao --}}
@endsection