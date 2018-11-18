<?php

namespace App\Http\Controllers;

use App\Http\Controllers\RoadController; 
use App\Http\Controllers\RequestController;
use App\Plan;
use App\Road;
use App\Slide;
use App\User;
use App\Request as JoinRequest;
use Carbon\Carbon; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB;

class PlanController extends Controller
{
    public function __construct() 
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response 
     */
    public function index()
    {
        $slides = Slide::all();
        $plans  = Plan::paginate(10);
        return view('plans.index', compact('plans', 'slides'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('plans.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //get data array from post request
        $data = json_decode($request->data);
        // echo $data[0]->start_place;
        $last_index = sizeof($data) - 1;

        // store plan info
        // note: roads table is upside down so the
        // index should be reverse from 0 to last_index (fixed, just dont wanna delete)
        $plan              = new Plan;
        $plan->name        = $request->plan_name;
        $plan->start_place = $data[$last_index]->start_place;
        $plan->start_time  = $data[$last_index]->start_time;
        $plan->end_place   = $data[0]->end_place;
        $plan->end_time    = $data[0]->end_time;
        $plan->status      = 0;
        $plan->picture     = $request->picture;
        $plan->save();

        if ($request->hasFile('plan_photo')) {
            $file = $request->file('plan_photo');
            $file->move('images/plans', $request->picture);
        }

        // store road info, one by one
        $road_controller = new RoadController;
        for ($i = 0; $i < sizeof($data); $i++) {
            $road_controller->store($plan->id, $data[$i]);
        }

        // TODO:
        // get current user, then
        // attach the plan to that user in the pivot table
        $user = User::find(Auth::id());
        $user->plans()->attach($plan->id, ['role' => 0]);

        return response()->json($plan->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $plan      = Plan::find($id);
        
        if($plan == null) 
            return redirect()->route('home');

        $all_users = $plan->users;

        $number_user   = $plan->users()->wherePivot('role', '<', 2)->count();
        $number_follow = $plan->users()->wherePivot('role', 2)->count() + $number_user;
        $user          = $plan->users()->wherePivot('role', 0)->first();
        // dd($user)    ;
        // to call relationship
        $auth_user     = User::find(Auth::id());
        $comments  = $plan->comments->where('parent_id', null)->sortBy('created_at');
        $start     = Road::where('plan_id', $id)->where('order_number', 1)->get();
        $waypoints = Road::where('plan_id', $id)->get();

        $current_time = Carbon::now();
        //dd($comments);
        return view('plans.show', compact('plan', 'comments', 'user', 'auth_user', 'start', 'waypoints', 'current_time', 'number_user',
            'number_follow'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $plan         = Plan::find($id);
        $current_time = Carbon::now();

        //dd($number_follow);
        return view('plans.edit', compact('plan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function updateBanner(Request $request)
    {
        if ($request->hasFile('plan_photo')) {
            $file = $request->file('plan_photo');
            $file->move('images/plans', $request->banner_name);
            return redirect()->route('plans.edit', $request->plan_id);
        }
    }

    public function updatePlanName(Request $request)
    {   
        $plan       = Plan::find($request->plan_id);
        $plan->name = $request->plan_name_tamp;
        $plan->save();
        return redirect()->route('plans.edit', $request->plan_id);
    }

    public function updateRoute(Request $request) 
    {
        $road_stamp = Road::all()->where('plan_id', $request->plan_id)->where('order_number', $request->order_number)->toArray();
        $id = $road_stamp[1]['id'];
        $road = Road::find($id);
        $road->start_place  = $request->start_place;
        $road->start_time   = $request->start_time;
        $road->end_place    = $request->end_place;
        $road->end_time     = $request->end_time;
        $road->vehicle      = $request->vehicle;
        $road->action       = $request->action;

        $road->save();
    }

    public function addRoute(Request $request)
    {

        $order_number = Road::where('plan_id',$request->plan_id)->count();

        $road = new Road;

        $road->plan_id      = $request->plan_id;
        $road->order_number = $order_number + 1;
        $road->start_place  = $request->start_place;
        $road->start_time   = $request->start_time;
        $road->end_place    = $request->end_place;
        $road->end_time     = $request->end_time;
        $road->vehicle      = $request->vehicle;
        $road->action       = $request->action;

        $road->save();
    }

    public function deleteRoute(Request $request)
    {

        $order_number = Road::where('plan_id',$request->plan_id)->count();
        $road = Road::where('order_number', $order_number)->delete();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //permanently deletion
        $plan = Plan::find($id);
        $plan->comments()->where('parent_id','<>',null)->forceDelete();
        $plan->comments()->forceDelete();
        $plan->roads()->forceDelete();
        $plan->requests()->forceDelete();
        $plan->delete();

        $user = User::find(Auth::id());
        $user->plans()->detach($plan->id);

        return redirect()->route('plans.index');
    }

    public function managePeople($id)
    {
        $plan          = Plan::find($id);
        $user          = $plan->users()->wherePivot('role', 0)->first();

        if(Auth::id() != $user->id)
            return redirect()->route('plans.index');

        $participants  = $plan->users()->wherePivot('role', 1)->get();
        $number_follow = $plan->users()->wherePivot('role', 2)->count();
        $requests      = $plan->requests()->where('status', 0)->get();
        // dd($request);
        
        $comments      = $plan->comments->where('parent_id', null)->sortBy('created_at');
        $start         = Road::where('plan_id', $id)->where('order_number', 1)->get();
        $waypoints     = Road::where('plan_id', $id)->get();

        $current_time = Carbon::now();
        return view('plans.joiner', compact('roads', 'requests', 'plan', 'user', 'comments', 'start', 'waypoints', 'current_time', 'participants'));
    }

    public function search(Request $request) 
    {
        $slides = Slide::all();

        if ($request->has('search')) {
            $plans = Plan::search($request->input('search'))->get();
        }
        // dd($plans);
        return view('plans.search', compact('plans', 'slides'));
    }

    public function kick(Request $request, $id)
    {
        $plan = Plan::find($id);
        $plan->users()->detach($request->user_id);
        $plan->requests()->where('user_id', $request->user_id)->delete();
        return $this->managePeople($id);
    }

    public function storeRequest(Request $request, $id, $userId){
        $reqCon = new RequestController;
        $reqCon->store($request, $id);
        $this->follow($request, $id, $userId);
        return redirect()->route('plans.show', $id);
    }

    public function follow(Request $request, $id, $userId){
        $plan = Plan::find($id);
        $hasRole = $plan->users()->where('user_id', $userId)->get();
        // dd($hasRole);

        if(sizeof($hasRole) == 0) {
            $user = User::find(Auth::id());
            $user->plans()->attach($plan->id, ['role' => 2]);
        }
        return redirect()->route('plans.show', $id);
    }

    public function unJoinRq($id){
        $stamp = DB::table('requests')->where('plan_id', $id)->where('user_id', Auth::id())->get()->toArray();
        $unFollowRq = DB::table('requests')->where('id', $stamp[0]->id)->delete();
        return redirect()->route('plans.show', $id);
    }
    public function unFollowRq($id){
        $stamp = DB::table('plan_user')->where('plan_id', $id)->where('user_id', Auth::id())->get()->toArray();
        $unJoinRq = DB::table('plan_user')->where('id', $stamp[0]->id)->delete();
        return redirect()->route('plans.show', $id);
    }
    public function turnOnPlan($id){
        $plan = Plan::find($id);
        $plan->status = 1;
        $plan->save();
        return redirect()->route('plans.show', $id);
    }
    public function turnOffPlan($id){
        $plan = Plan::find($id);
        $plan->status = 0;
        $plan->save();
        return redirect()->route('plans.show', $id);
    }
    public function accept(Request $request, $id, $userId){
        //update request
        $jRequest = JoinRequest::find($request->request_id);
        $jRequest->status = 1;
        $jRequest->save();

        //update role
        $plan = Plan::find($id);
        $user = $plan->users()->where('user_id', $userId)->first();
        $user->pivot->role = 1;
        $user->pivot->save();
        // dd($plan->users);
        return $this->managePeople($id);
    }

    public function deny(Request $request, $id, $userId){
        //update request
        $jRequest = JoinRequest::find($request->request_id);
        $jRequest->status = 2;
        $jRequest->save();
        return $this->managePeople($id);
    }
}
