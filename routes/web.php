<?php

use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;
use App\Models\Todos;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    $todos = Todos::all();

    return view('index', compact('todos'));
});

Route::post('/todos', 'TodoController@store');
Route::patch('/todos/{id}/update-status', [TodoController::class, 'updateStatus']);
Route::put('/todos/{id}', 'TodoController@update');
Route::put('/todos/{id}/complete', 'TodoController@complete');
Route::delete('/todos/{id}', 'TodoController@destroy');
