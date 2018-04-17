<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Tasks APIs
Route::group(['prefix' => 'v1/tasks', 'namespace' => 'Task'], function (){
    Route::post('start-task', 'TaskController@startTask');
    Route::post('deliver-task', 'TaskController@deliverTask');
});

// Tasks Bulk APIs
Route::group(['prefix' => 'tasks-bulk', 'namespace' => 'Bulk'], function () {
    Route::post('/', 'TasksBulkController@createUnAssignedBulkOfTasks');
});

// Testing APIs
Route::get('users', 'Pet@index');
Route::middleware(['docs', 'test'])->get('users', 'Pet@index');


