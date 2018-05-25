<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
/ routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
*/

//Route::get('/', function () {
  //     //eturn "hello World";
    // return view('welcome');
//});
//Route::get('/users/{id}', function ($id) {
//    return 'This is user'.$id;
//});
//Route::get('/register', function () {
  //  return view('register');
//});
//Route::get('/login', function () {
//    return view('login');
//});
Route::match(['get','post'],'/admin','AdminController@login');
Route::get('/admin/dashboard','AdminController@dashboard');
Route::get('/admin/settings','AdminController@settings');
Route::get('/admin/check-pwd','AdminController@chkPassword');
Route::match(['get','post'],'/admin/update-pwd','AdminController@updatePassword');

Route::get('/logout','AdminController@logout');
Route::get('/logs','AdminController@login');

//Category Routes
Route::match(['get','post'],'/admin/add-category','CategoryController@addCategory');
Route::match(['get','post'],'/admin/edit-category/{id}','CategoryController@editCategory');
Route::match(['get','post'],'/admin/delete-category/{id}','CategoryController@deleteCategory');
Route::get('/admin/view-categories','CategoryController@viewCategories');



Auth::routes();
Route::match(['get','post'],'/','HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');
