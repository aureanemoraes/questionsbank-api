<?php

use Illuminate\Http\Request;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('subjects', 'SubjectController')->only(['index', 'store', 'update', 'destroy']);
Route::resource('grades', 'GradeController')->only(['index', 'store', 'update', 'destroy']);
Route::resource('topics', 'TopicController')->only(['index', 'store', 'update', 'destroy']);


