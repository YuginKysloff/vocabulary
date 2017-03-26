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

// Welcome page
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Vocabulary list
Route::get('/vocabulary', 'VocabularyController@getVocabulary')->name('vocabulary');

// Results list
Route::post('/hash', 'VocabularyController@getHash')->name('hash');

// Save selected hash
Route::get('/hash/save/{word_id}/{algorithm_id}/{hash}', 'VocabularyController@saveHash');