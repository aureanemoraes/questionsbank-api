<?php

use Illuminate\Http\Request;


//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::group(['middleware' => ['guest:api']], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
});
Route::group(['middleware' => 'auth:api'], function() {
    Route::get('logout', 'AuthController@logout');
    Route::get('getuser', 'AuthController@getUser');
    Route::apiResources([
        'areas' => 'AreaController',
        'grades' => 'GradeController',
        'subjects' => 'SubjectController',
        'topics' => 'TopicController',
        'users' => 'UserController',
        'answertypes' => 'AnswerTypeController',
        'questionlevels' => 'QuestionLevelController',
        'questions' => 'QuestionController'
    ]);
});



