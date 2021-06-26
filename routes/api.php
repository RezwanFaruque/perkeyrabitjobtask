<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::namespace('Api')->middleware('api')->group(function () {

    Route::post('/user/register','UserAuthController@register')->name('user.register');
    Route::post('/user/login','UserAuthController@login')->name('user.login');
});

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::namespace('Api')->middleware('auth:api')->group(function () {

    Route::apiResource('employees', 'EmployeeController');

    Route::get('/fetchalldesignation','EmployeeController@fetchAllDesignation')->name('employee.fetchalldesignation');

    Route::post('/search-employee','EmployeeController@employeeSearch')->name('employee.search');

    Route::post('/save-selected-employee','EmployeeController@saveSelectedEmployee')->name('employee.savesel');


});

