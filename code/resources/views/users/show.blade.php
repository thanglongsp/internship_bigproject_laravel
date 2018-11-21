@extends('users.profile')
@section('content2')
<div>
   {{--  <h3>User's Infomation </h3>
    <br> --}}
    <div class=".col-s-3">
        <table style="width:100%">
            <tr>
                <th>Name </th>
                <td>{{ $user->name }}</td>
            </tr> 
            <tr>
                <th>Gender </th>
                @if($user->gender == 1)
                <td>Male</td>
                @else
                <td>Female</td>
                @endif
            </tr>
            <tr>
                <th>Phone number </th>
                <td>{{ $user->phone_number }}</td>
            </tr>
            <tr>
                <th>Birth day </th>
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