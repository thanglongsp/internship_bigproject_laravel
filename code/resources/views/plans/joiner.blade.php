@extends('layouts.master_joiner_management')

@section('content')
<!--Lưu điểm bắt đầu-->
<input type="hidden" id="start" value="{{$start[0]['start_place']}}"></input>
<!--Lưu các điểm còn lại 'waypoints'-->
<p hidden id="waypoints">
    @foreach($waypoints as $waypoint)
    @if($waypoint->end_place != null)
    {{$waypoint->end_place}}.
    @endif
    @endforeach
</p>
<div class="container-fluid mb-3">
    <div class="row"> 
        <div class="offset-sm-1 col-sm-4">
            <h1>{{$plan->name}}</h1>
        </div>
        <div class="col-sm-3 ml-auto">
            <!-- Dành cho người muốn tham gia hay theo dõi kế hoạch --> 
            @if($user->id != Auth::user()->id)
            <a href="javascript:void(0)" class="btn btn-outline-success">Xin tham gia</a>
            <a href="javascript:void(0)" class="btn btn-outline-primary">Theo dõi</a>
            @else
            <!-- dành cho chủ kế hoạch -->
            <a href="{{route('plans.edit',$plan->id)}}" class="btn btn-primary">Sửa kế hoạch</a>
            <form method="POST" action="{{route('plans.destroy',$plan->id)}}" style="display: initial;">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <button type="submit" class="btn btn-danger">Xóa kế hoạch</a>
                </form>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="offset-sm-1 col-sm-4">
                <img src="{{asset('images/plans/'.$plan->picture)}}" width="400px" height="300px"><!--Hình ảnh xem trước-->
            </div>
            <div class="col-sm-6">
                <div id="map"></div>
            </div>
        </div>
    <div class="row mt-3">
        <div class="col-sm-2 offset-sm-1">
            <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="pill" href="#joinedlist">Danh sách tham gia</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" href="#wanttojoinlist">Yêu cầu tham gia <span class="float-sm-right want-to-join-number">{{sizeof($requests)}}</span></a>
                </li>
            </ul>
        </div>
        <div class="col-sm-8 tab-content">
            <div id="joinedlist" class="tab-pane show in active">
                @foreach($participants as $participant)
                <div class="card">
                    <div class="card-body">
                        <div class="media">
                            <img class="mr-3" src="{{asset('images/avatars/'.$participant->avatar)}}" 
                            width="150px">
                            <div class="media-body">
                                <h5 class="mt-0">
                                    <a href="{{route('users.show', $participant->id)}}">{{$participant->name}}</a>
                                </h5>
                                <p>Ngày sinh: {{$participant->birthday}}</p>
                                <p>Email: {{$participant->email}}</p>        
                            </div>
                        </div>
                        <form method="POST" action="{{route('kick_user', $plan->id)}}">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <input type="hidden" name="user_id" value="{{$participant->id}}">
                            <button type="submit" class="card-link btn btn-outline-danger mt-1" style="height:38px;width:150px">Loại</a>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
            <div id="wanttojoinlist" class="tab-pane fade">
                @foreach($requests as $request)
                <div class="card">
                    <div class="card-body">
                        <div class="media">
                            <img class="mr-3" src="{{asset('images/avatars/'.$request->user->avatar)}}" width="150px"> 
                            <div class="media-body">
                                <h5 class="mt-0"><a href="#">{{$request->user->name}}</a></h5>
                                <p>Email : {{$request->user->email}}</p>        
                            </div>
                        </div>
                        <form method="post" action="{{route('acceptRequest', [$plan->id, $request->user->id])}}">
                            @csrf
                            <button type="submit" name="request_id" class="card-link btn btn-outline-primary mt-1" value="{{$request->id}}" style="height:38px;width:150px">Chấp nhận</button>
                        </form>
                        <form method="post" action="{{route('denyRequest', [$plan->id, $request->user->id])}}">
                            @csrf
                            <button type="submit" name="request_id" class="card-link btn btn-outline-danger mt-1" value="{{$request->id}}" style="height:38px;width:150px">Loại</button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection