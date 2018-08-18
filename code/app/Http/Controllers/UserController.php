<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \App\Http\Requests\UpdateAccountRequest;

class UserController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        // if ($id != Auth::id())
        //     return redirect('/');
        $user = User::find($id);
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('users.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAccountRequest $request, $id)
    {
        $user        = User::find($id);
        $user->name  = $request->get('inputName');
        $user->email = $request->get('inputEmail');
        $birthday = date_create_from_format('m/d/Y', $request->get('birthday'));

        if ($birthday != null) {
            // dd($birthday);
            // dd($request->get('birthday'));
            $user->birthday = $birthday;
        }
        $user->phone_number = $request->get('phone_number');

        // $user->password = bcrypt( $request->get('inputPassword'));

        // Update mật khẩu ...
        if ($request->get('inputPassword') != null && $request->get('inputPassword') == $request->get('inputPassword_confirmation')) {
            $user->password = bcrypt($request->get('inputPassword'));
            $user->save();
            Auth::logout();
        }
        $user->avatar = 'avatar'.Auth::user()->id;
        $user->save();

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $file->move('images/avatars', 'avatar'.Auth::user()->id);
        }

        return redirect()->route('users.show', $user->id);
    }

    public function myFollowings($id)
    {
        $user = User::find($id);
        $following = $user->plans()->wherePivot('role', 2)->paginate(5);

        return view('users.myfollowings', compact('following','user'));
    }

    public function myJoineds($id)
    {
        $user = User::find($id);
        $joined = $user->plans()->wherePivot('role', 1)->paginate(5);

        return view('users.myjoineds', compact('joined', 'user'));
    }

    public function myPlans($id)
    {
        $user = User::find($id);
        $mine = $user->plans()->wherePivot('role', 0)->paginate(5);

        return view('users.myplans', compact('mine', 'user'));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
