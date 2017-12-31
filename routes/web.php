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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/verify_email/{token}', 'Auth\RegisterController@verify');

// Logout
Route::any('/logout', function() { //TODO Не доделал
    Auth::logout();
    return redirect()->back();
})->name('logout');

// Contact
Route::get('contact', function() {
    return view('contact');
})->name('contact');

// ======== AdminPanel =========================
Route::group(['prefix' => 'admin'], function() {
    Route::group(['prefix' => 'post'], function() {
// Route::group(['prefix' => 'admin/post', 'middleware' => ['auth', 'admin']], function () {

        Route::get('index', 'Admin\AdminPostController@index')->name('adminIndex');
        Route::post('create', 'Admin\AdminPostController@store')->name('postStore');
        Route::get('create', 'Admin\AdminPostController@create')->name('postCreate');
        Route::get('update.{id}', 'Admin\AdminPostController@edit')->name('postEdit');
        Route::post('update', 'Admin\AdminPostController@update')->name('postUpdate');
        Route::delete('destroy.{id}', 'Admin\AdminPostController@destroy')->name('postDelete');
        Route::delete('delete.{post}.{tag}', 'Admin\AdminPostController@deleteTag')->name('postTagDelete');
        Route::get('restore.{post}', 'Admin\AdminPostController@restore')->name('postRestore');
        Route::get('status.{post}', 'Admin\AdminPostController@statusChange')->name('postStatusChange');
    });

    Route::group(['prefix' => 'user'], function() {

        Route::get('index', 'Admin\AdminUserController@index')->name('userIndex');
        Route::get('update.{id}', 'Admin\AdminUserController@edit')->name('userEdit');
        Route::post('update', 'Admin\AdminUserController@update')->name('userUpdate');
        Route::delete('delete.{id}', 'Admin\AdminUserController@destroy')->name('userDelete');
        Route::get('restore.{user}', 'Admin\AdminUserController@restore')->name('userRestore');
    });

    Route::group(['prefix' => 'category'], function() {

        Route::get('index', 'Admin\AdminCategoryController@index')->name('categoryIndex');
        Route::post('create', 'Admin\AdminCategoryController@store')->name('categoryStore');
        Route::get('create', 'Admin\AdminCategoryController@create')->name('categoryCreate');
        Route::get('update.{id}', 'Admin\AdminCategoryController@edit')->name('categoryEdit');
        Route::any('update', 'Admin\AdminCategoryController@update')->name('categoryUpdate');
        Route::delete('category.{category}', 'Admin\AdminCategoryController@destroy')
            ->name('categoryDelete');
        Route::get('category.restore.{category}', 'Admin\AdminCategoryController@restore')
            ->name('categoryRestore');
        Route::get('status.{category}', 'Admin\AdminCategoryController@statusChange')
            ->name('categoryStatusChange');
    });

    Route::resource('file', 'Admin\AdminFileController', [
        'only' => [
            'store',
            'update',
            'destroy',
        ],
        [
            'names' => [
                'store' => 'file.store',
                'update' => 'file.update',
                'destroy' => 'file.destroy',
            ]
        ]
    ]);
});


// ======== MyExample =======================
// Route::post('registerX.{id?}', function() {

	// 	$route = Route::current(); // new Route
	// 	echo $route->getName; // покажет 'registerX'
	// 	echo $route->getParameter('id', 25); // id, 25 - default
	// 	print_r($route->parameters()); // покажет массив с параметрами

// })->name('registerX');

// php artisan make:controller PhotoController --resource --model=Photo
// Route::resource('/pages', 'PhotoController', [
	// 'except'=> ['index', 'show'] // исключить методы: index, show
	// ]); // CRUD (RESTfull: post, get, put, delete)

// Route::controller('/pages', 'NewController'); // methods: getShow, getIndex, postStore и др.

// uses ... as -> назначить имя,
// Route::controller('/pages', ['uses' => 'NewController', 'as' => 'post', 'middleware' => 'mymiddle:admin']); //admin - параметр
// Route::controller('/pages', ['uses' => 'NewController', 'as' => 'post'])->middleware(['mymiddle']); 

// ============================================

//Contact
Route::get('contact', function () { return view('contact'); })->name('contact');
Route::post('contact.mail', 'ContactController@contactMail')->name('contactMail');

//posts
Route::get('/', ['as' => 'index', 'uses' => 'SiteController@index']);
Route::get('post.{id}', 'SiteController@show')->name('postShow');
Route::get('category.{categoryId}', 'SiteController@showByCategory')->name('postByCategory');

//Comments
Route::get('comment{id}', 'CommentController@show')->name('commentShow');
Route::post('post', 'CommentController@store')->name('commentStore');
Route::delete('delete.{comment}', 'CommentController@delete')->name('commentDelete');

// ======== AdminPanel =========================
Route::group(['prefix' => 'admin/post'], function () {
// Route::group(['prefix' => 'admin/post', 'middleware' => ['auth', 'admin']], function () {

	Route::get('index', 'Admin\AdminPostController@index')->name('adminIndex');
	Route::post('create', 'Admin\AdminPostController@store')->name('postStore');
	Route::get('create', 'Admin\AdminPostController@create')->name('postCreate');
	Route::get('update.{id}', 'Admin\AdminPostController@update')->name('postUpdate');
	Route::post('update', 'Admin\AdminPostController@postUpdate')->name('postPostUpdate');
	Route::delete('delete.{post}', 'Admin\AdminPostController@delete')->name('postDelete');
	Route::post('upload', 'Admin\AdminPostController@uploadFile')->name('upload');
});

Route::group(['prefix' => 'admin/category'], function () {

	Route::get('index', 'Admin\AdminCategoryController@index')->name('categoryIndex');
	Route::post('create', 'Admin\AdminCategoryController@store')->name('categoryStore');
	Route::get('create', 'Admin\AdminCategoryController@create')->name('categoryCreate');
	Route::get('update.{id}', 'Admin\AdminCategoryController@update')->name('categoryUpdate');
	Route::get('delete.{post}', 'Admin\AdminCategoryController@delete')->name('categoryDelete');
});
// ======== END AdminPanel =======================

// ======== Authentication =======================
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

// login
Route::get('loginX', 'Auth\LoginController@showLoginForm')->name('loginX');
Route::post('loginX', 'Auth\LoginController@login')->name('loginX');
Route::get('logoutX', 'Auth\LoginController@logout')->name('logoutX');

// register
Route::get('registerX', 'Auth\RegisterController@showRegistrationForm')->name('registerX');
Route::post('registerX', 'Auth\RegisterController@register')->name('registerX');
// ======== END Authentication =======================
