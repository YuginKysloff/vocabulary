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
Route::post('/hash/save', 'VocabularyController@saveHash');

// Get current user's stored words.
Route::get('/account/{id}', 'VocabularyController@getAccount')->name('account');