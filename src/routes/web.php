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

Route::get('/', function () {
    return view('front.index');
})->name('index');

// Frontend without Auth
Route::get('/projects', 'GuestController@projects')->name('front.projects');

// Frontend with Auth
Route::group(['middleware' => 'auth'], function() {
	Route::match(['get', 'post'], '/profile', 'AlumnoController@dashboard')->name('dashboard');
	Route::match(['get', 'post'], '/project', 'AlumnoController@project')->name('myproject');
});

// Administration
Route::group(['middleware' => 'App\Http\Middleware\BackendMiddleware'], function() {
	Route::match('get', '/administrator', 'AdminController@admin')->name('administrator');
});

// Admin General
Route::group(['middleware' => 'App\Http\Middleware\AdminMiddleware'], function() {
	Route::match(['get', 'post'], '/administrator/config', 'AdminController@config')->name('config');	
	Route::match(['get', 'post'], '/administrator/centers', 'AdminController@centers')->name('centers');
	Route::match('get', '/administrator/centers/new', 'AdminController@newcenter')->name('newcenter');
	Route::match(['get', 'post'], '/administrator/centers/studies/new', 'AdminController@newstudy')->name('newstudy');	
	Route::match(['get', 'post'], '/administrator/centers/department/new', 'AdminController@newdepartment')->name('newdepartment');	
	Route::match(['get', 'post'], '/administrator/centers/admins', 'AdminController@centeradmins')->name('centeradmins');	
	Route::match(['get', 'post'], '/administrator/centers/admins/new', 'AdminController@newcenteradmin')->name('newcenteradmin');
});

// Admin de Centro
Route::group(['middleware' => 'App\Http\Middleware\AdminCentroMiddleware'], function() {
	Route::match(['get', 'post'], '/administrator/centers/{id}/edit', 'AdminCentroController@editcenter')->where('id', '[0-9]+')->name('editcenter');
	Route::match(['get', 'post'], '/administrator/centers/{id}', 'AdminCentroController@getstudies')->where('id', '[0-9]+')->name('getstudies');
	Route::match(['get', 'post'], '/administrator/centers/{id}/studies/new', 'AdminCentroController@newstudy')->where('id', '[0-9]+')->name('newcenterstudy');
	Route::match(['get', 'post'], '/administrator/centers/{id}/studies/{s_id}/edit', 'AdminCentroController@editstudy')->where('id', '[0-9]+')->where('s_id', '[0-9]+')->name('editstudy');
	Route::match(['get', 'post'], '/administrator/centers/{id}/topic/new', 'AdminCentroController@newtopic')->where('id', '[0-9]+')->name('newtopic');
	Route::match(['get', 'post'], '/administrator/centers/studies/admins', 'AdminCentroController@studyadmins')->name('studyadmins');	
	Route::match('get', '/administrator/centers/studies/admins/new', 'AdminCentroController@newstudyadmin')->name('newstudyadmin');	
});

// Tutor
Route::group(['middleware' => 'App\Http\Middleware\TutorMiddleware'], function() {
	Route::match(['get', 'post'], '/administrator/projects/{id}', 'TutorController@projects')->where('id', '[0-9]+')->name('projects');	
	Route::match('get', '/administrator/projects/{id}/new', 'TutorController@newproject')->where('id', '[0-9]+')->name('newproject');
	Route::match('get', '/administrator/project/{id}/assign/{project}', 'TutorController@assignproject')->where('id', '[0-9]+')->where('project', '[0-9]+')->name('assignproject');	
});

// Coordinador
Route::group(['middleware' => 'App\Http\Middleware\CoordinadorMiddleware'], function() {
	Route::match(['get', 'post'], '/administrator/studies/{id}/students', 'CoordinadorController@students')->where('id', '[0-9]+')->name('studystudents');
	Route::match('get', '/administrator/studies/{id}/students/new', 'CoordinadorController@newstudent')->where('id', '[0-9]+')->name('newstudent');
	Route::match(['get', 'post'], '/administrator/studies/{id}/tutors', 'CoordinadorController@tutors')->where('id', '[0-9]+')->name('studytutors');	
	Route::match(['get', 'post'], '/administrator/studies/{id}/courts', 'CoordinadorController@courts')->where('id', '[0-9]+')->name('studycourts');	
	Route::match('get', '/administrator/studies/{id}/courts/new', 'CoordinadorController@newcourt')->where('id', '[0-9]+')->name('newcourt');	
	Route::match('get', '/administrator/studies/{id}/tutors/new', 'CoordinadorController@newtutor')->where('id', '[0-9]+')->name('newtutor');
	Route::match('get', '/administrator/studies/{id}/courts/{num}', 'CoordinadorController@setscore')->where('id', '[0-9]+')->where('num', '[0-9]+')->name('setscore');		
});

// Authentication Routes...
$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login');
$this->get('logout', 'Auth\LoginController@logout')->name('logout');

// Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset');