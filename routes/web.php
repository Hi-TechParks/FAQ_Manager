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

// Home Route
Route::get('/', 'HomeController@index')->name('home');


/*Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles','RoleController');
    Route::resource('users','UserController');
    Route::resource('products','ProductController');
});*/


// Faq Routes
Route::get('/faqs', 'FaqsController@index');
Route::get('/faq/category/{id}', 'FaqsController@category');
Route::get('/faq/location/{id}', 'FaqsController@location');
Route::get('/faq/{id}', 'FaqsController@show');

// Search Route
Route::get('/search', 'SearchController@index');

Route::get('/search/question', 'SearchController@question')->name('question');
Route::get('/search/location', 'SearchController@location')->name('location');
Route::get('/search/category', 'SearchController@category')->name('category');

// Contact Route
Route::get('/ask', 'AskController@index');
Route::post('/ask', 'AskController@sendMail');
Route::get('/contact', 'ContactController@index');
Route::post('/contact', 'ContactController@sendMail');


route::get('/email', function(){
    return view('emails.email');
});


// Auth Routes
Auth::routes();
// Auth::routes(['register' => false]);

// Admin Routes
Route::group(['prefix' => 'admin',  'middleware' => 'auth'], function()
{
    // Dashboard Route
    Route::get('/', 'Admin\DashboardController@index')->name('dashboard.index');
    Route::get('dashboard', 'Admin\DashboardController@index')->name('dashboard.index');

    // User Role Route
    Route::resource('role','Admin\RoleController');
    Route::resource('user','Admin\UserController');
    Route::resource('products','Admin\ProductController');

    // Admin Routes
	Route::resource('faq-category', 'Admin\FaqCategoryController');
    Route::resource('faq-default', 'Admin\FaqDefaultController');
    Route::resource('location', 'Admin\LocationController');
    // Route::resource('faq', 'Admin\FaqController');

    // Faqs Routes
    Route::get('faq/approve', 'Admin\FaqController@approve')->name('faq.approve');
    Route::get('faq/pending', 'Admin\FaqController@pending')->name('faq.pending');
    Route::get('faq/reject', 'Admin\FaqController@reject')->name('faq.reject');
    Route::put('faq/{id}', 'Admin\FaqController@update')->name('faq.update');
    Route::delete('faq/{id}', 'Admin\FaqController@destroy')->name('faq.destroy');

    // Setting Routes
    Route::get('setting', 'Admin\SettingController@index')->name('setting.index');
    Route::post('siteinfo', 'Admin\SettingController@siteInfo')->name('setting.siteinfo');
    Route::post('contactinfo', 'Admin\SettingController@contactInfo')->name('setting.contactinfo');
    Route::post('changepass', 'Admin\SettingController@changePass')->name('setting.changepass');
    Route::post('socialinfo', 'Admin\SettingController@socialInfo')->name('setting.socialinfo');
    Route::post('aboutus', 'Admin\SettingController@aboutUs')->name('setting.aboutus');
});
