<?php
  
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/ 
  
Auth::routes(); 
// Common 
Route::get('/','PageController@index');
Route::get('/hottestPlans','PageController@hottestPlans');
Route::get('/latestUsers','PageController@latestUsers'); 
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home'); 
 
// Plans 
Route::resource('plans','PlanController');
Route::get('/plans/{id}/joiner-management','PlanController@managePeople');
Route::post('/plans/{id}/joiner-management/accept-request/{userId}', 'PlanController@accept')->name('acceptRequest');
Route::post('/plans/{id}/joiner-management/deny-request/{userId}', 'PlanController@deny')->name('denyRequest');
Route::post('/plans/banner/update',[
	'as'=>'update_banner',
	'uses'=>'PlanController@updateBanner'
]);
Route::post('/plans/planname/update',[
	'as'=>'update_plan_name',
	'uses'=>'PlanController@updatePlanName'
]);
Route::post('/plans/route/update',[
	'as'=>'update_route',
	'uses'=>'PlanController@updateRoute'
]);
Route::post('/plans/route/add',[
	'as'=>'add_route',
	'uses'=>'PlanController@addRoute'
]);
Route::get('/plans/route/delete',[
	'as'=>'delete_route',
	'uses'=>'PlanController@deleteRoute'
]);
Route::get('/plans/destroy/{id}',[
	'as'=>'delete_plan',
	'uses'=>'PlanController@destroy'
]);
Route::post('/plans/test',[
	'as'=>'plans.test',
	'uses'=>'PlanController@test'
]);



Route::get('/users/{id}',[ 
    'as'=>'users.show', 
    'uses'=>'UserController@show'
]);

Route::get('/users/{id}/my-following-plans','UserController@myFollowings');
Route::get('/users/{id}/my-plans','UserController@myPlans');
Route::get('/users/{id}/my-joined-plans','UserController@myJoineds');

Route::get('/users/{id}/edit',[
    'as'=>'users.edit',
    'uses'=>'UserController@edit'
]);
Route::put('/users/{id}',[
    'as'=>'users.update',
    'uses'=>'UserController@update'
]);

Route::post('/comments',[
	'as'=>'comments.store',
	'uses'=>'CommentController@store'
]);
Route::post('/comments/edit/{id}',[
	'as'=>'comments.edit',
	'uses'=>'CommentController@edit'
]);


Route::get('/comments/destroy/{id}/{planId}',[
	'as'	=>	'comments.destroy',
	'uses'	=>	'CommentController@destroy'
]);

Route::get('/search','PlanController@search');

Route::post('/plans/{id}/joiner-management', [
	'as' => 'kick_user',
	'uses' => 'PlanController@kick'
]);

Route::post('/plans/{id}/follow/{userId}', [
	'as' => 'follow',
	'uses' => 'PlanController@follow'
]);

Route::post('/plans/{id}/request/{userId}', [
	'as' => 'store_request',
	'uses' => 'PlanController@storeRequest'
]);
