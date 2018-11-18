<?php

namespace App\Http\Controllers;

use App\Road;
use Illuminate\Http\Request;

class RoadController extends Controller
{ 
    //
    public function store($plan_id, $data){
    	$road = new Road;
    	$road->plan_id = $plan_id;
    	$road->order_number = $data->order_number;
    	$road->start_place = $data->start_place;
    	$road->end_place = $data->end_place;
    	$road->start_time = $data->start_time;
    	$road->end_time = $data->end_time;
    	$road->vehicle = $data->vehicle;
    	$road->action = $data->action;
    	$road->save();
	}
	
	public function destroy($id)
    {
        $road = Road::find($id);
        $road->delete();
        return redirect()->route('plans.index');//có thể sửa nếu cần thiết
    }
}
