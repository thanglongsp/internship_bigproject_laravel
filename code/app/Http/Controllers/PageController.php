<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Slide;
use App\Plan;
use App\User;
use App\PlanUser;

class PageController extends Controller
{
	public function index(){
		$plans = Plan::orderBy('created_at', 'desc')
		->take(10)
		->get();
		$slides = Slide::all();
		return view('index',compact('slides','plans'));
	}

	public function hottestPlans(){
		// put this in PlanController
		$plans = Plan::has('users')->where('status', '<', 2)->get();
		$temps = collect();
		foreach ($plans as $plan) {
			$count = $plan->users()->wherePivot('role', '<', 2)->count();
			$id = $plan->id;
			$temps->push((object)array('id' => $id, 'count' => $count));
		}
		//sort temps theo so nguoi tham gia
		$temps = $temps->sortByDesc('count');

		//sort plan lay dc o temp
		$sortedPlans = collect();
		foreach ($temps as $temp) {
			$plan = Plan::find($temp->id);
			$sortedPlans->push($plan);
		}
		// lay 10
		$sortedPlans = $sortedPlans->take(10);

		$slides = Slide::all();
		return view('hottest-plans',compact('slides', 'sortedPlans'));//khi thành công thì sẽ đưa ra view index
	}

	public function latestUsers(){
		// put this in UserController
		$users = User::orderBy('created_at', 'desc')
		->take(10)
		->get();
		$slides = Slide::all();
		return view('latest-users',compact('slides', 'users'));//khi thành công thì đổi tên blade test thành latest-user
	}
}
