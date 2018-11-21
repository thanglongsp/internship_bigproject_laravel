<!--Đây là trang show tất cả các kế hoạch-->
@extends('layouts.master')

@section('content')
@include('layouts.slider')
<div class="container-fluid">
    <div class='row'>
        <div class='col-sm-2'>
            <div class="card">
                <div class="card-header">
                    You can see :
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><a href="{{action('PageController@index')}}">10 new plans</a></li>
                    <li class="list-group-item"><a href="{{action('PageController@hottestPlans')}}">10 hot plans</a></li>
                    <li class="list-group-item"><a href="{{action('PageController@latestUsers')}}">10 new users</a></li>
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
                                <p class="card-text">Start time : {{$plan->start_time}}</p>
                                <p class="card-text">End time : {{$plan->end_time}}</p>
                                <p class="card-text">Number people : </p>
                                <p class="card-text">Status : {{$plan->status}}</p>
                            </div>
                        </div>
                        <a href="{{route('plans.show',$plan->id)}}" class="btn btn-primary">More ... </a>
                    </div>
                </div>
            @endforeach
            {{ $plans->links() }}
        </div>
    </div>
</div>
@endsection