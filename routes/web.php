<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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
Auth::routes();

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' , 'auth']
    ], function(){

    Route::resource('grades', 'GradeController');
    Route::resource('classrooms', 'ClassroomController');
    Route::resource('teachers', 'TeacherController');


    Route::post('classrooms/delete-all', 'ClassroomController@delete_all')->name('delete_all');
    Route::post('classrooms/filter-by-grade', 'ClassroomController@filter_by_grade')->name('filter-by-grade');



    //==============================parents============================

    Route::view('add_parent','livewire.show-form');

    Route::get('/', 'HomeController@index')->name('dashboard');

});





