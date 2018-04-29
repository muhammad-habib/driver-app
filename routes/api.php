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

Route::group(['middleware' => 'lang'], function () { // Langauge Detection
    
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::group(['middleware' => 'auth.driver'], function(){ // Driver Authentication
        Route::get('logout', 'AuthController@logout');
        // Driver Profile APIs
        Route::group(['prefix' => 'profile', 'namespace' => 'Profile'], function () {
            Route::get('/', 'ProfileController@index');
            Route::post('/edit', 'ProfileController@edit');
            Route::get('/tasks-history', 'TasksHistoryController@getTasksHistory');
        });
    });    

    // Tasks APIs
    Route::group(['prefix' => 'v1/tasks', 'namespace' => 'Task'], function (){
        Route::post('start-task', 'TaskController@startTask');
        Route::post('deliver-task', 'TaskController@deliverTask');
        Route::post('refuse-task', 'TaskController@refuseTask');
        Route::post('acknowledge-task-failure', 'TaskController@acknowledgeTaskFailure');
        Route::post('assign-task', 'TaskController@assignTask');
        Route::post('reassign-task', 'TaskController@ReassignTask');
        Route::post('acknowledge-task-arrival', 'TaskController@acknowledgeTaskArrival');
        Route::get('ready-tasks', 'TaskController@readyTasks');
    });

    // Tasks Bulk APIs
    Route::group(['prefix' => 'tasks-bulk', 'namespace' => 'Bulk'], function () {
        Route::post('/', 'TasksBulkController@createUnAssignedBulkOfTasks');
    });
    
});

// Testing APIs
Route::get('users', 'Pet@index');
Route::middleware(['docs', 'test'])->get('users', 'Pet@index');