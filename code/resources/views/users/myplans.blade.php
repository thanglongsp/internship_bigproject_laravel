@extends('users.profile')

@section('content2')
            <div>                
                @if(sizeof($mine) == 0)
                <p>Haven't any plan ... </p>
                @endif                
                @foreach($mine as $plan)
                <div class="card">
                    <h5 class="card-header">{{$plan->name}}</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3"><img src="{{asset('images/plans/'.$plan->picture)}}" width="100%" style="margin-bottom: 5px" ></div>
                            <div class="col-sm-9">
                                <p class="card-text">Start time : {{$plan->start_time}}</p>
                                <p class="card-text">End time : {{$plan->end_time}}</p>
                                <p class="card-text">Number people : 
                                    {{$plan->users()->wherePivot('role', '<', 2)->count()}}</p>
                                @if($plan->status == 0)
                                <p class="card-text">Status : Is planning ... </p>
                                @elseif($plan->status == 1)
                                <p class="card-text">Status : Being deployed</p>
                                @else
                                <p class="card-text">Status : Finished</p>
                                @endif
                            </div>
                        </div>
                        <a href="{{route('plans.show', $plan->id)}}" class="btn btn-primary">More ... </a>
                    </div>
                </div>
                @endforeach
                {{$mine->links()}} 
            </div>
@endsection