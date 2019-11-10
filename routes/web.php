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


// Faq Routes
Route::get('/faqs', 'FaqsController@index');
Route::get('/faq/category/{slug}', 'FaqsController@category');
Route::get('/faq/location/{slug}', 'FaqsController@location');
Route::get('/faq/{id}', 'FaqsController@show')->name('single.faq.show');

// Search Route
Route::get('/search', 'SearchController@index')->name('search');
Route::get('/new', 'SearchController@new')->name('new');

Route::get('/search/question', 'SearchController@question')->name('question');
Route::get('/search/location', 'SearchController@location')->name('location');
Route::get('/search/category', 'SearchController@category')->name('category');

// Contact Route
Route::get('/ask', 'AskController@index');
Route::post('/ask', 'AskController@sendMail')->name('ask.sendMail');
Route::get('/contact', 'ContactController@index');
Route::post('/contact', 'ContactController@sendMail')->name('contact.sendMail');


route::get('/email', function(){
    return view('emails.email');
});


// Auth Routes
// Auth::routes();
Auth::routes(['register' => false]);

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

    // Profile Route
    Route::resource('profile', 'Admin\ProfileController');

    // Admin Routes
	Route::resource('faq-category', 'Admin\FaqCategoryController');
    Route::resource('faq-default', 'Admin\FaqDefaultController');
    Route::resource('location', 'Admin\LocationController');
    // Route::resource('faq', 'Admin\FaqController');

    // Faqs Routes
    Route::get('faq/approve', 'Admin\FaqController@approve')->name('faq.approve');
    Route::get('faq/pending', 'Admin\FaqController@pending')->name('faq.pending');
    Route::get('faq/reject', 'Admin\FaqController@reject')->name('faq.reject');
    Route::get('faq/{id}/{status}', 'Admin\FaqController@edit')->name('faq.edit');
    Route::put('faq/{id}', 'Admin\FaqController@update')->name('faq.update');
    Route::delete('faq/{id}', 'Admin\FaqController@destroy')->name('faq.destroy');
    Route::get('faq/sendMail/{id}/{status}', 'Admin\FaqController@sendMail')->name('faq.sendMail');
    Route::get('faq/back', 'Admin\FaqController@back')->name('faq.back');

    // Setting Routes
    Route::get('setting', 'Admin\SettingController@index')->name('setting.index');
    Route::post('siteinfo', 'Admin\SettingController@siteInfo')->name('setting.siteinfo');
    Route::post('contactinfo', 'Admin\SettingController@contactInfo')->name('setting.contactinfo');
    Route::post('socialinfo', 'Admin\SettingController@socialInfo')->name('setting.socialinfo');
    Route::post('aboutus', 'Admin\SettingController@aboutUs')->name('setting.aboutus');
    Route::post('changepass', 'Admin\SettingController@changePass')->name('profile.changepass');
});
