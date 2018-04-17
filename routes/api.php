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

Route::group(['prefix' => 'tasks-bulk', 'namespace' => 'Bulk'], function () {
    Route::post('/', 'TasksBulkController@createUnAssignedBulkOfTasks');
});

Route::group(['prefix' => 'task', 'namespace' => 'Task'], function () {
    Route::post('/deliver', 'TaskController@deliverTask');
});

Route::get('users', 'Pet@index');
Route::middleware(['docs', 'test'])->get('users', 'Pet@index');

