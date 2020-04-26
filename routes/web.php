<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/helloworld', function () {
    return "hello world";
});

Route::get('/help', function () {
    return "Help Page";
});


Route::get('/posts/{id}', function ($id) {
    return "Viewing the current post " . $id;
});


Route::get('/notes/{id}/{page}', function ($id, $page) {
    return "View the current note: " . $id . " on the current page:" . $page;
});

Route::get('/book', function () {
    if(isset($_GET['id'])){
        return "Viewing the book via the id " . $_GET['id'];
    }else{
        return  "No book id given";
    }
});

Route::post('/create', function(){
    return "test";
});



Route::get('/dashboard', 'DashboardController@index');


Route::get('/login', function () {
    return "login page";
});


Route::redirect('/home', '/login');


Route::get('/admin', function () {
    return redirect('/help');
});

// Users Routes
Route::get('/users/show', 'UsersController@show');
