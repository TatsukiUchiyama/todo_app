<?php

use Illuminate\Support\Facades\Route;

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




Route::group(['middleware' => 'auth'], function(){
  Route::get('/', 'App\Http\Controllers\HomeController@index')->name('home');
  Route::get('/folders/create', 'App\Http\Controllers\FolderController@showCreateForm')->name('folders.create');
  Route::post('/folders/create', 'App\Http\Controllers\FolderController@create');

  Route::group(['middleware' => 'can:view,folder'], function() {
    Route::get('/folders/{folder}/tasks', 'App\Http\Controllers\TaskController@index')->name('tasks.index');
    Route::get('/folders/{folder}/tasks/create', 'App\Http\Controllers\TaskController@showCreateForm')->name('tasks.create');
    Route::get('/folders/{folder}/tasks/{task}/edit', 'App\Http\Controllers\TaskController@showEditForm')->name('tasks.edit');
    Route::post('/folders/{folder}/tasks/create', 'App\Http\Controllers\TaskController@create');
    Route::post('/folders/{folder}/tasks/{task}/edit', 'App\Http\Controllers\TaskController@edit');
  });


});
Auth::routes();
