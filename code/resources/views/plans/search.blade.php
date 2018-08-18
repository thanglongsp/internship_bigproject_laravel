<!--Đây là trang show tất cả các kế hoạch-->
@extends('layouts.master')

@section('content')
@include('layouts.slider')
<div class="container-fluid">
    <div class='row'>
        <div class='col-sm-2'>
            Kết quả tìm kiếm
        </div>
        <div class='col-sm-10'>
            @foreach($plans as $plan)
                <div class="card">
                    <h5 class="card-header">{{$plan->name}}</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3"><img src="{{asset('images/plans/'.$plan->picture)}}" width="100%" style="margin-bottom: 5px" ></div>
                            <div class="col-sm-9">
                                <p class="card-text">Thời gian bắt đầu: {{$plan->start_time}}</p>
                                <p class="card-text">Thời gian kết thúc: {{$plan->end_time}}</p>
                                <p class="card-text">Số lượng người: </p>
                                <p class="card-text">Trạng thái: {{$plan->status}}</p>
                            </div>
                        </div>
                        <a href="{{route('plans.show',$plan->id)}}" class="btn btn-primary">Xem thêm</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection