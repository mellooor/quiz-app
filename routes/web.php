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

Route::get('/quizzes', 'App\Http\Controllers\QuizController@index')->name('all-quizzes');
Route::get('/topic/{topicID}/quizzes', 'App\Http\Controllers\QuizController@indexByTopic')->name('quizzes-by-topic');
Route::get('/user/{userID}/quizzes', 'App\Http\Controllers\QuizController@indexByUser')->name('quizzes-by-user');
Route::get('/quiz/{quizID}', 'App\Http\Controllers\QuizController@show')->name('quiz');

/*
 * All routes that require a user to be logged in.
 */
Route::middleware('auth')->group(function()
{
    Route::delete('/user', 'App\Http\Controllers\UserController@destroy')->name('delete-profile');
    Route::get('/update-profile-information', 'App\Http\Controllers\UserController@edit')->name('update-profile');
});

/*
 * All routes that require an administrator to be logged in.
 */
Route::middleware(['auth', 'admin'])->group(function()
{
    Route::get('/quiz-topics', 'App\Http\Controllers\QuizTopicController@index')->name('quiz-topics');
    Route::post('/quiz-topic', 'App\Http\Controllers\QuizTopicController@store')->name('create-quiz-topic');
    Route::put('/quiz-topic/{id}', 'App\Http\Controllers\QuizTopicController@update')->name('update-quiz-topic');
    Route::delete('/quiz-topic/{id}', 'App\Http\Controllers\QuizTopicController@destroy')->name('delete-quiz-topic');
    Route::get('/new-quiz', 'App\Http\Controllers\QuizController@create')->name('new-quiz');
    Route::post('/new-quiz', 'App\Http\Controllers\QuizController@store')->name('create-new-quiz');
    Route::get('{id}/questions', 'App\Http\Controllers\QuizQuestionController@create')->name('create-quiz-questions');
    Route::get('/edit-quiz/{id}', 'App\Http\Controllers\QuizController@edit')->name('edit-quiz');
    Route::put('/edit-quiz/{id}', 'App\Http\Controllers\QuizController@update')->name('update-quiz');
});
