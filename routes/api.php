<?php

use Illuminate\Http\Request;


//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::apiResources([
    'areas' => 'AreaController',
    'grades' => 'GradeController',
    'subjects' => 'SubjectController',
    'topics' => 'TopicController',
    'teacherUsers' => 'TeacherUserController'
]);
