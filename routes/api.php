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
    Route::get('answertypes/options', 'AnswerTypeController@indexToOption');
    Route::get('questionlevels/options', 'QuestionLevelController@indexToOption');
    Route::get('grades/options', 'GradeController@indexToOptions');
    Route::get('subjects/options/{grade_id}', 'SubjectController@indexToOptions');
    Route::get('topics/options/{subject_id}', 'TopicController@indexToOption');




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



