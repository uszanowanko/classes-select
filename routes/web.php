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

/************ STUDENT ROUTES ************/

Route::get('/', function() {
    return view('student/welcome');
});

Route::post('/login', [
    'uses' => 'Student\LoginController@loginStudent',
    'as' => 'student.login'
]);

Route::post('/logout', [
    'uses' => 'Student\LoginController@logoutStudent',
    'as' => 'student.logout'
]);

Route::get('/dashboard', [
    'uses' => 'Student\DashboardController@index',
    'as' => 'student.dashboard'
])->middleware('auth');

/************ ADMIN ROUTES ************/

Route::group(['prefix' => 'admin'], function()
{
    Route::get('/', function() {
        return view('admin/welcome');
    });
    
    Route::get('/students', [
        'uses' => 'Admin\StudentController@index',
        'as' => 'admin.students'
    ]);
    
    Route::post('/students', [
        'uses' => 'Admin\StudentController@index',
        'as' => 'admin.students'
    ]); 
    
    Route::get('/student/{id?}', [
        'uses' => 'Admin\StudentController@getStudentForm',
        'as' => 'admin.getstudent'
    ])->where('id', '[0-9]+');
    
    Route::post('/student/{id?}', [
        'uses' => 'Admin\StudentController@saveStudent',
        'as' => 'admin.savestudent'
    ])->where('id', '[0-9]+');

    Route::delete('/student/{id}', [
        'uses' => 'Admin\StudentController@deletestudent',
        'as' => 'admin.deletestudent'
    ])->where('id', '[0-9]+');
    
    Route::get('/faculty/{id?}', [
        'uses' => 'Admin\FacultyController@getFacultyForm',
        'as' => 'admin.addfaculty'
    ])->where('id', '[0-9]+');
});

// to jest strefa dla Mateusza i Grzesia do testowania pojedynczych widoków. Proszę tu nie grzebać, poza nimi dwoma
// Oni są panami tej strefy i tu może być szyf taki jaki zrobią, Poźniej to im skasujemy.
//-------------------------------------------------------------------------------------------------------------------------


Route::group(['prefix' => 'testowanie'], function() {

Route::get('/sb', function() {
    return view('student.selectableSubject');
});
});

//-------------------------------------------------------------------------------------------------------------------------

