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


Route::group(['prefix' => 'v1', 'namespace' => 'DriverApp', 'middleware' => 'lang'], function () {
    
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::group(['middleware' => 'auth.driver'], function(){ // Driver Authentication
        Route::get('logout', 'AuthController@logout');
        
        // Driver Profile APIs
        Route::group(['namespace' => 'Profile'], function () {
            Route::group(['prefix' => 'profile'], function(){
                Route::get('/', 'ProfileController@index');
                Route::post('/edit', 'ProfileController@edit');
                Route::get('/tasks-history', 'TasksHistoryController@getTasksHistory');
            });

            // Driver start & end shift
            Route::get('start-shift', 'ShiftsController@startShift');
            Route::get('end-shift', 'ShiftsController@endShift');
        });

        // Tasks APIs
        Route::group(['prefix' => 'tasks', 'namespace' => 'Task'], function (){
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

    
});

Route::group(['namespace' => 'Portal', 'middleware' => 'lang'], function (){

    // teams APIs
    Route::group(['prefix' => 'v1/teams', 'namespace' => 'Team'], function (){
        Route::get('/', 'TeamController@teams');
        Route::post('/', 'TeamController@createTeam');
        Route::put('/{team_id}', 'TeamController@updateTeam');
        Route::delete('/{team_id}', 'TeamController@deleteTeam');
    });

    // company APIs
    Route::group(['prefix' => 'v1/webhooks', 'namespace' => 'Company'], function(){
        Route::get('/', 'WebhooksController@webhooks');
        Route::post('/', 'WebhooksController@addWebhook');
        Route::put('/{webhook_id}', 'WebhooksController@updateWebhook');
        Route::delete('/{webhook_id}', 'WebhooksController@deleteWebhook');
    });
});


Route::post('/push-repo', 'Development\DeploymentController@pullDevelopmentBranch');
// Testing APIs
Route::get('users', 'Pet@index');
Route::middleware(['docs', 'test'])->get('users', 'Pet@index');
