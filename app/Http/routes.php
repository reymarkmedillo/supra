<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// "GUESTS ROUTE"
Route::group(['middleware' => ['web']], function() {
    // "LOGIN PAGE"
    Route::get('/signin', ['as'=> 'getSignIn', 'uses' => 'Auth\AuthController@getLogin']);
    Route::post('/signin', ['as'=> 'postSignIn', 'uses' => 'Auth\AuthController@postLogin']);
    // "FORGOT PASSWORD"
    Route::get('/forgot', ['as'=> 'getForgotPassword', 'uses' => 'Auth\AuthController@getForgotPassword']);
    Route::post('/forgot', ['as' => 'postForgotPassword', 'uses' => 'Auth\AuthController@postForgotPassword']);
    Route::get('/forgot-password/{token}', ['as'=> 'getForgotPasswordToken', 'uses' => 'Auth\AuthController@getForgotPasswordToken']);
    Route::post('/forgot-password/{token}', ['as'=> 'postForgotPasswordToken', 'uses' => 'Auth\AuthController@postForgotPasswordToken']);
});

// "AUTHENTICATED ROUTE - WEB USERS"
Route::group(['middleware' => ['session_auth']], function() {
    // "TOP PAGE"
    Route::get('/', 
        [
            'as'   => 'top',
            // 'uses' => 'IndexController@getIndex'
            'uses'=>'CaseController@listCase'
        ]
    );
    // "CASE PAGES"
    Route::get('/case/new', ['as'=>'createCase', 'uses'=>'CaseController@createCase']);
    Route::post('/case/new', ['as'=>'postCreateCase', 'uses'=>'CaseController@postCreateCase']);
    Route::get('/case/list', ['as'=>'listCase', 'uses'=>'CaseController@listCase']);
    // APPROVED CASES
    Route::get('/case/approved/list', ['as'=>'listApprovedCase', 'uses'=>'CaseApprovedController@listCase']);
    Route::get('/case/approved/view/{case_id}', ['as' => 'viewApprovedCase', 'uses' => 'CaseApprovedController@viewCase']);
    Route::post('/case/approved/update/{case_id}', ['as'=>'postUpdateApprovedCase', 'uses'=>'CaseApprovedController@postUpdateApprovedCase']);
    // USER PAGES
    Route::post('/users/update/{user_id}', ['as'=>'postUpdateUser', 'uses'=>'UserController@postUpdateUser']);
    Route::get('/users', ['as'=>'getUsers', 'uses'=>'UserController@getUsers']);
    Route::get('/users/add', ['as'=>'getAddUser', 'uses'=>'UserController@getAddUser']);
    Route::post('/users/add', ['as'=>'postAddUser', 'uses'=>'UserController@postAddUser']);
    Route::get('/users/view/{user_id}', ['as'=>'getEditUser', 'uses'=>'UserController@getEditUser']);
    // "AJAX ROUTES"
    Route::get('/case/category/{parent_id}', ['as'=> 'getCategory','uses'=> 'CaseController@getCategory']);
    Route::post('/case/approve/{case_id}', ['as'=>'postApproveCase', 'uses'=>'CaseController@postApproveCase']);
    Route::post('/list-dropdown/case-by-category', ['as'=>'getCasesByCategory', 'uses'=>'ReportController@getCasesByCategory']);
    Route::get('/case/remove/{case_id}', ['as'=>'deleteCase', 'uses'=>'CaseApprovedController@deleteCase']);
    Route::get('/users/remove/{user_id}', ['as'=>'postRemoveUser', 'uses'=>'UserController@postRemoveUser']);
    // "CATEGORIES"
    Route::get('/category/new', ['as'=> 'createCategory','uses'=> 'CategoryController@createCategory']);
    Route::post('/category/new', ['as'=> 'postCreateCategory','uses'=> 'CategoryController@postCreateCategory']);
    Route::get('/category/edit', ['as'=> 'editCategory','uses'=> 'CategoryController@editCategory']);
    Route::post('/category/edit', ['as'=> 'postEditCategory','uses'=> 'CategoryController@postEditCategory']);
    Route::get('/category/update/{category_id}', ['as'=> 'updateCategory','uses'=> 'CategoryController@updateCategory']);
    Route::post('/category/update/{category_id}', ['as'=> 'postUpdateCategory','uses'=> 'CategoryController@postUpdateCategory']);
    // "REPORTS"
    Route::get('/reports/syllabus', ['as'=> 'getCategoryTree','uses'=> 'ReportController@getCategoryTree']);
    Route::get('/reports/syllabus-tree', function() {
        return redirect('/reports/syllabus?action=rw');
    });
    Route::post('/reports/syllabus-tree', ['as'=> 'postCategoryTree','uses'=> 'ReportController@postCategoryTree']);
});

// "AUTHENTICATED ROUTE - MOBILE USERS"


// "AUTHENTICATED ROUTE - WEB AND MOBILE USERS"
Route::group(['middleware' => ['session_auth']], function() {
    // "LOGOUT"
    Route::get('/signout', ['as'=>'signOut', 'uses'=>'Auth\AuthController@logout']);
    // "CHANGE PASSWORD"
    Route::get('/change-password', ['as'=>'getChangePassword', 'uses'=>'UserController@getChangePassword']);
    Route::post('/change-password', ['as'=>'postChangePassword', 'uses'=>'UserController@postChangePassword']);
    // "EDIT PROFILE"
    Route::get('/user/edit', ['as'=>'editProfile', 'uses'=>'UserController@editProfile']);
    Route::post('/user/update', ['as'=>'updateProfile', 'uses'=>'UserController@updateProfile']);

    Route::get('/user/highlights', ['as'=>'getUserHighlights', 'uses'=>'UserController@getUserHighlights']);
});

