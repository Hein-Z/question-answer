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
    return redirect()->route('question.index');
})->middleware('auth');

Route::resource('question', 'QuestionController')->middleware('auth');
Route::resource('question.answer', 'AnswerController')->except(['index', 'create', 'show'])->middleware('auth');
Route::post('question/{question}/acceptBestAnswer/{id}', 'AnswerController@acceptBestAnswer')->name('question.answer.acceptBestAnswer')->middleware('auth');
Route::post('question/{question}/favourite', 'QuestionController@favourite')->name('question.favourite')->middleware('auth');

Route::post('answer/{answer}/vote', 'VoteController@answer')->name('answer.vote')->middleware('auth');
Route::post('question/{question}/vote', 'VoteController@question')->name('question.vote')->middleware('auth');


Auth::routes();


