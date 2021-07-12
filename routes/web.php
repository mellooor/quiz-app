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

Route::get('/', function () {
    return redirect('/home');
});

Route::get('/home', function() {
   return view('home');
})->name('home');

Route::middleware('auth')->group(function()
{
    Route::delete('/user', 'App\Http\Controllers\UserController@destroy')->name('delete-profile');
    Route::get('/update-profile-information', 'App\Http\Controllers\UserController@edit')->name('update-profile');
});

Route::middleware(['auth', 'admin'])->group(function()
{
    Route::get('/quiz-topics', 'App\Http\Controllers\QuizTopicController@index')->name('quiz-topics');
    Route::post('/quiz-topics', 'App\Http\Controllers\QuizTopicController@store')->name('create-quiz-topic');
    Route::put('/quiz-topics/{id}', 'App\Http\Controllers\QuizTopicController@update')->name('update-quiz-topic');
});
