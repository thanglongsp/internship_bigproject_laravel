<!--Đây là trang show tất cả các kế hoạch-->
@extends('layouts.master')

@section('content')
@include('layouts.slider')
<div class="container-fluid">
    <div class='row'>
        <div class='col-sm-2'>
            <div class="card">
                <div class="card-header">
                    Bạn nên xem
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><a href="{{action('PageController@index')}}">10 kế hoạch mới nhất</a></li>
                    <li class="list-group-item"><a href="{{action('PageController@hottestPlans')}}">10 kế hoạch hot nhất</a></li>
                    <li class="list-group-item"><a href="{{action('PageController@latestUsers')}}">10 người dùng mới nhất</a></li>
                </ul>
            </div>
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
            {{ $plans->links() }}
        </div>
    </div>
</div>
@endsection