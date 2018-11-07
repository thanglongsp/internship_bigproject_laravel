@extends('layouts.master_planshow')
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
                {{-- Nếu chưa có request --}}
                @if($auth_user->requests()->where('plan_id', $plan->id)->first() == null)
                    <form method="post" action="{{route('store_request', [$plan->id, $auth_user->id])}}">
                        @csrf
                        <button type="submit" class="btn btn-outline-primary" style="height:38px;width:110px">Xin tham gia</button>
                    </form>
                    {{-- Nếu chưa follow --}}
                    @if($auth_user->plans()->where('plan_id', $plan->id)->wherePivot('role', 2)->first() == null)
                        <form method="post" action="{{route('follow', [$plan->id, $auth_user->id])}}">
                            @csrf
                            <button type="submit" class="btn btn-outline-secondary" style="height:38px;width:110px">Theo dõi</a>
                        </form>  
                    @else
                        <button type="button" class="btn btn-outline-secondary">Đang theo dõi</a>
                    @endif

                @elseif($auth_user->requests()->where('plan_id', $plan->id)->first()->status == 0)
                    <button type="button" class="btn btn-outline-success">Đã xin tham gia</button>
                    <button type="button" class="btn btn-outline-secondary">Đang theo dõi</a>
                @elseif($auth_user->requests()->where('plan_id', $plan->id)->first()->status == 1)
                    <button type="button" class="btn btn-outline-success">Đã tham gia</button>
                    <button type="button" class="btn btn-outline-secondary">Đang theo dõi</a>
                @elseif($auth_user->requests()->where('plan_id', $plan->id)->first()->status == 2)
                    <button type="button" class="btn btn-outline-success">Bị từ chối</button>
                    <button type="button" class="btn btn-outline-secondary">Đang theo dõi</a>
                @endif

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
        <div class="row">
            <div class="offset-sm-1 col-sm-11">
                Người lập kế hoạch: <a href="javascript:void(0)">{{$user->name}}</a>
            </div>
        </div>
        <div class="row">
            <div class="offset-sm-1 col-sm-8 table-responsive">
                <table class="table table-striped">
                    <thead class="roads-list">
                        <tr>
                            <th>Điểm xuất phát</th>
                            <th>Thời gian xuất phát</th>
                            <th>Điểm kết thúc</th>
                            <th>Thời gian kết thúc</th>
                            <th>Phương tiện</th>
                            <th>Hoạt động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($plan->roads as $road)
                        <tr>
                            <td>{{ $road->start_place }}</td>
                            <td>{{ $road->start_time }}</td>
                            <td>{{ $road->end_place }}</td>
                            <td>{{ $road->end_time }}</td>
                            <td>{{ $road->vehicle }}</td>
                            <td>{{ $road->action }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-sm-2">
                @if($plan->status == 0)
                <p>Trạng thái : Đang lên kế hoạch </p>
                @elseif($plan->status == 1)
                <p>Trạng thái : Đang triển khai</p>
                @else
                <p>Trạng thái : Đã hoàn thành</p>
                @endif
                <p>Số người tham gia: {{$number_user}}</p>
                <p>Số người theo dõi: {{$number_follow}}</p>
            
                @if($user->id == Auth::user()->id)
                <a href="/plans/{{$plan->id}}/joiner-management" class="btn btn-info">Quản lý người tham gia</a><!-- Thêm lệnh if ở đây để ẩn với người ko phải chủ kế hoạch-->
                @endif
            </div>
        </div>
        <div>
            @foreach( $comments as $comment )
            <div class="row" >
                <div class="offset-sm-1 col-sm-11 media mt-3">
                    <a class="pr-3" href="{{route('users.show',$comment->user->id)}}">
                        <img class="mr-3 img-responsive" src="{{asset('images/avatars/'.$comment->user->avatar)}}" alt="Generic placeholder image" width="64px">
                    </a>
                    <div class="media-body parent-comment">
                        <a href="{{route('users.show',$comment->user->id)}}" class="mt-0"><b>{{ $comment->user->name}}</b></a>
                        <p class="comment_info">{{ $comment->checkin_location }}<br>{{ $comment->created_at}}</p>
                        {{ $comment->content}}
                        <br>
                        @if($comment->picture != null)
                        @foreach(explode(', ',$comment->picture) as $picture)
                        <img class="mr-3 img-responsive" src="{{asset('images/comments/'.$picture)}}" width="200px" height="150px" alt="Generic placeholder image">

                        @endforeach
                        @endif
                        <div class="panel-heading">
                            <p class="panel-title">
                                <a class="btn btn-link" data-toggle="collapse" data-parent="#accordion" href="#rep{{$comment->id}}" data-toggle="tooltip" title="Các câu trả lời" >{{$comment->replies->count()}} <i class="fas fa-reply"></i></a>
                                @if($comment->user_id == Auth::user()->id)
                                <a class="btn btn-link text-danger" href="{{route('comments.destroy',[$comment->id,$plan->id])}}" data-toggle="tooltip" title="Xóa bình luận"><i class="far fa-trash-alt"></i></a>
                                <a class="btn btn-link text-danger" href="javascript:void(0)" data-toggle="modal" data-target="#{{$comment->id}}" title="Sửa bình luận"><i class="fas fa-pencil-alt"></i></a>
                                <!-- Modal -->
                                  <div class="modal fade" id="{{$comment->id}}" role="dialog">
                                    <div class="modal-dialog">
                                    
                                      <!-- Modal content-->
                                      <div class="modal-content">
                                        <div class="modal-body">
                                          <p>Edit comment</p>
                                          <form method="post" action="{{route('comments.edit',$comment->id)}}">
                                            @csrf
                                                <input type="text" class="form-control" name="{{$comment->id}}" value="{{$comment->content}}"/>
                                                <button type="submit" class="btn btn-outline-secondary">Submit</a>
                                            </form> 
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                      </div>
                                      
                                    </div>
                                  </div>
                                @endif
                            </p>
                        </div>
                        <div id="rep{{$comment->id}}" class="panel-collapse collapse">
                            @foreach( $comment->replies as $reply )
                            <div class="media mt-3">
                                <a class="pr-3" href="{{route('users.show',$reply->user->id)}}">
                                    <img class="mr-3 img-responsive" src="{{asset('images/avatars/'.$reply->user->avatar)}}" alt="Generic placeholder image" width="64px">
                                </a>
                                <div class="media-body">
                                    <a href="{{route('users.show',$reply->user->id)}}" class="mt-0">{{ $reply->user->name }}</a>
                                    <p class="comment_info">{{ $reply->checkin_location }}<br>{{ $reply->created_at}}</p>
                                    {{ $reply->content }}
                                    <br>
                                    @if($reply->picture != null)
                                    @foreach(explode(', ',$reply->picture) as $picture)
                                    <img class="mr-3 img-responsive" src="{{asset('images/comments/'.$picture)}}" width="200px" height="150px"  alt="Generic placeholder image">

                                    @endforeach
                                    @endif
                                    <div class="panel-heading">
                                        <p class="panel-title">
                                            @if($reply->user_id == Auth::user()->id)
                                            <a class="btn btn-link text-danger" href="{{route('comments.destroy',[$reply->id,$reply->plan_id])}}" data-toggle="tooltip" title="Xóa bình luận"><i class="far fa-trash-alt"></i></a>
                                            <a class="btn btn-link text-danger" href="javascript:void(0)" data-toggle="modal" data-target="#{{$reply->id}}" title="Sửa bình luận"><i class="fas fa-pencil-alt"></i></a>
                                            <!-- Modal -->
                                              <div class="modal fade" id="{{$reply->id}}" role="dialog">
                                                <div class="modal-dialog">
                                                
                                                  <!-- Modal content-->
                                                  <div class="modal-content">
                                                    <div class="modal-body">
                                                      <p>Edit comment</p>
                                                      <form method="post" action="{{route('comments.edit',$reply->id)}}">
                                                        @csrf
                                                            <input type="text" class="form-control" name="{{$reply->id}}" value="{{$reply->content}}"/>
                                                            <button type="submit" class="btn btn-outline-secondary">Submit</a>
                                                        </form> 
                                                    </div>
                                                    <div class="modal-footer">
                                                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    </div>
                                                  </div>
                                                  
                                                </div>
                                              </div>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            <div class="media mt-3">
                                <a class="pr-3" href="#">
                                    <img class="mr-3 img-responsive" src="{{asset('images/avatars/'.Auth::user()->avatar)}}" alt="Generic placeholder image" width="64px">
                                </a>
                                <div class="media-body">
                                    <div class="input-group mb-3">
                                        <form action="{{route('comments.store')}}" method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                                            <input type="hidden" name="name_place" id="name_place"></input>
                                            <input type="hidden" name="parent_id" value="{{$comment->id}}">
                                            <input type="hidden" id="plan_id" name="plan_id" value="{{$plan->id}}"></input>
                                            <input name="comment" type="text" class="form-control" placeholder="Trả lời bình luận..." aria-label="Recipient's username" aria-describedby="basic-addon2">
                                            <div class="upload-btn-wrapper">
                                                <button class="plan-img-upload"><i class="fas fa-upload"></i></button>    
                                                <input class="btn btn-default" type="file" id="upImage" name="upImage[]" multiple></input>
                                            </div>
                                            <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#myModal" onclick="takePicture(this.value)" value="{{$comment->id}}">Chụp ảnh</a>
                                                <button class="btn btn-outline-primary" type="submit">Trả lời</button>
                                            <div>
                                                <canvas id="canvasReply{{$comment->id}}" width=320 height=240></canvas>
                                            </div>
                                            <input type="hidden" name="srcImage" id="srcImage"></intput>
                                            </form>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="row">
                    <div class="offset-sm-1 col-sm-11 media mt-3">
                        <img class="mr-3 img-responsive" src="{{asset('images/avatars/'.Auth::user()->avatar)}}" alt="Generic placeholder image" width="64px">
                        <div class="media-body parent-comment">
                            <div class="input-group mb-3 mt-0">
                                <form action="{{route('comments.store')}}" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <input type="hidden" name="name_place" id="name_place"></input>
                                    <input type="hidden" name="parent_id" value="">
                                    <input type="hidden" id="plan_id" name="plan_id" value="{{$plan->id}}"></input>
                                    <input id="comment" name="comment" type="text" class="form-control" placeholder="Bình luận..." aria-label="Recipient's username" aria-describedby="basic-addon2">
                                    <div class="upload-btn-wrapper">
                                        <button class="plan-img-upload"><i class="fas fa-upload"></i></button>
                                        <input class="btn btn-default" type="file" id="upImage" name="upImage[]" multiple></input>
                                    </div>
                                    <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#myModal" onclick="takePicture(this.value)" value="comment">Chụp ảnh</a>
                                    <button class="btn btn-outline-primary" type="submit">Bình luận</button>
                                    <div>
                                        <canvas id="canvasComment" width=320 height=240></canvas>
                                    </div>
                                    <input type="hidden" name="srcImage" id="srcImage"></intput>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div id="myModal" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Modal Header</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <video id="player" autoplay width=320 height=240></video>
                                    <button id="capture">Capture</button>
                                    <!-- <canvas id="canvas" width=320 height=240></canvas> -->

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endsection