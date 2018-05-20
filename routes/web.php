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

//Route::get('/verify_email/{token}', 'Auth\RegisterController@verify');

// Logout
Route::any('/logout', function() { //TODO Не доделал?
    Auth::logout();
    return redirect()->back();
})->name('logout');

// Contact
//Route::get('contact', function() {
//    return view('contact');
//})->name('contact');

//Contact
Route::get('contact', function () { return view('contact'); })->name('contact');
//Route::post('contact.mail', 'ContactController@contactMail')->name('contactMail');

//posts
Route::get('/', ['as' => 'index', 'uses' => 'SiteController@index']);
Route::get('post.{id}', 'SiteController@show')->name('postShow');
Route::any('category.{categoryId}', 'SiteController@showByCategory')->name('showByCategory');
Route::any('category', 'SiteController@reSortPosts')->name('reSortPosts');
Route::post('search', 'SiteController@searchPost')->name('searchPost');
//Route::any('ajax_sort', 'SiteController@ajaxSort')->name('ajaxSort');

//Comments
Route::get('comment{id}', 'CommentController@show')->name('commentShow');
Route::post('post', 'CommentController@store')->name('commentStore');
Route::delete('delete.{comment}', 'CommentController@delete')->name('commentDelete');

Route::any('ajax_captcha_refresh', 'PostController@ajaxCaptchaRefresh')->name('ajaxCaptchaRefresh');

Route::group(['prefix' => 'post'], function() {
    Route::get('index', 'PostController@index')->name('postIndex');
    Route::get('create', 'PostController@create')->name('postCreate');
    Route::post('store', 'PostController@store')->name('postStore');
    Route::get('show.{id}', 'PostController@show')->name('postShow');
    Route::get('update.{id}', 'PostController@edit')->name('postEdit');
    Route::post('update', 'PostController@update')->name('postUpdate');
    Route::delete('delete.{id}', 'PostControllerr@destroy')->name('postDelete');
    Route::any('ajax_validate', 'PostController@ajaxValidate')->name('ajaxValidate');
    Route::get('download.{filename}', 'PostController@downloadFile')->name('downloadFile');
});

// ======== AdminPanel =========================
Route::group(['prefix' => 'admin'], function() {
    Route::group(['prefix' => 'post'], function() {
// Route::group(['prefix' => 'admin/post', 'middleware' => ['auth', 'admin']], function () {

        Route::get('index', 'Admin\AdminPostController@index')->name('adminIndex');
        Route::post('create', 'Admin\AdminPostController@store')->name('adminPostStore');
        Route::post('create', 'Admin\AdminPostController@create')->name('adminPostCreate');
        Route::get('update.{id}', 'Admin\AdminPostController@edit')->name('adminPostEdit');
        Route::post('update', 'Admin\AdminPostController@update')->name('adminPostUpdate');
        Route::delete('destroy.{id}', 'Admin\AdminPostController@destroy')->name('adminPostDelete');
        Route::get('restore.{post}', 'Admin\AdminPostController@restore')->name('adminPostRestore');
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

