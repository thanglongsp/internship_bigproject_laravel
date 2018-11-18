@extends('users.profile')

@section('content2')
            <div>
                @if(sizeof($joined) == 0)
                <p>Hiện chưa tham gia kế hoạch nào</p>
                @endif                
                @foreach($joined as $plan)
                <div class="card">

                    <h5 class="card-header">{{$plan->name}}</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3"><img src="{{asset('images/plans/'.$plan->picture)}}" width="100%" style="margin-bottom: 5px" ></div>
                            <div class="col-sm-9">
                                <p class="card-text">Thời gian bắt đầu: {{$plan->start_time}}</p>
                                <p class="card-text">Thời gian kết thúc: {{$plan->end_time}}</p>
                                <p class="card-text">Số lượng người: 
                                    {{$plan->users()->wherePivot('role', '<', 2)->count()}}</p>
                                @if($plan->status == 0)
                                <p class="card-text">Trạng thái: Đang lên kế hoạch</p>
                                @elseif($plan->status == 1)
                                <p class="card-text">Trạng thái: Đang triển khai</p>
                                @else
                                <p class="card-text">Trạng thái: Đã hoàn thành</p>
                                @endif
                            </div>
                        </div>
                        <a href="{{route('plans.show', $plan->id)}}" class="btn btn-primary">Xem thêm</a>
                    </div>
                </div>
                @endforeach
                {{$joined->links()}}
            </div>
@endsection