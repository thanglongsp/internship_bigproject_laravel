<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Request as JoinRequest;

class RequestController extends Controller
{
    //
    public function store(Request $request, $id){
    	$jRequest = new JoinRequest;
    	$jRequest->user_id = Auth::id();
    	$jRequest->plan_id = $id;
    	$jRequest->status = 0;
    	$jRequest->save();
    }

    public function accept(Request $request, $id){
    	
    }
}
