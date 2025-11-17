<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::group(['middleware'=>'auth'],function()
{
    Route::get('home',function()
    {
        return view('dashboard.home');
    });
    Route::get('home',function()
    {
        return view('dashboard.home');
    });
});

Auth::routes();

Route::group(['namespace' => 'App\Http\Controllers\Auth'],function()
{
    // -----------------------------login----------------------------------------//
    Route::controller(LoginController::class)->group(function () {
        Route::get('/login', 'login')->name('login');
        Route::post('/login', 'authenticate');
        Route::get('/logout', 'logout')->name('logout');
        Route::get('logout/page', 'logoutPage')->name('logout/page');
    });

    // ------------------------------ register ----------------------------------//
    Route::controller(RegisterController::class)->group(function () {
        Route::get('/register', 'register')->name('register');
        Route::post('/register','storeUser')->name('register');    
    });

    // ----------------------------- forget password ----------------------------//
    Route::controller(ForgotPasswordController::class)->group(function () {
        Route::get('forget-password', 'getEmail')->name('forget-password');
        Route::post('forget-password', 'postEmail')->name('forget-password');    
    });

    // ----------------------------- reset password -----------------------------//
    Route::controller(ResetPasswordController::class)->group(function () {
        Route::get('reset-password/{token}', 'getPassword');
        Route::post('reset-password', 'updatePassword');    
    });
});

Route::group(['namespace' => 'App\Http\Controllers'],function()
{
    Route::middleware('auth')->group(function () {
        // --------------------- main dashboard ------------------//
        Route::controller(HomeController::class)->group(function () {
            Route::get('/home', 'index')->name('home');
            Route::get('profile', 'profile')->name('profile');
        });
    });

    // ------------------------ Product ------------------------//
    Route::middleware('auth')->prefix('product')->group(function () {
        Route::controller(ProductController::class)->group(function () {
            Route::get('list', 'list')->name('product/list');
            Route::get('add', 'add')->name('product/add');
            Route::get('categorylist', 'categoryList')->name('product/categorylist');
            Route::get('addcategory', 'addCategory')->name('product/addcategory');
            Route::get('subcategorylist', 'subCategoryList')->name('product/subcategorylist');
            Route::get('subaddcategory', 'subAddCategory')->name('product/subaddcategory');
            Route::get('brandlist', 'brandList')->name('product/brandlist');
            Route::get('addbrand', 'addBrand')->name('product/addbrand');
            Route::get('importproduct', 'importProduct')->name('product/importproduct');
            Route::get('barcode', 'barcode')->name('product/barcode');
        });
    });

    // ------------------------ Sales ---------------------------//
    Route::middleware('auth')->prefix('sales')->group(function () {
        Route::controller(SalesController::class)->group(function () {
            Route::get('list', 'list')->name('sales/list');
            Route::get('returnlist', 'returnList')->name('sales/returnlist');
            Route::get('return', 'return')->name('sales/return');
            Route::get('details', 'details')->name('sales/details');
            Route::get('edit', 'edit')->name('sales/edit');
        });
    });
    
    // ------------------------ Expenses ------------------------//
    Route::middleware('auth')->prefix('expenses')->group(function () {
        Route::controller(ExpensesController::class)->group(function () {
            Route::get('list', 'list')->name('expenses/list');
            Route::get('create', 'create')->name('expenses/create');
            Route::get('category', 'category')->name('expenses/category');
        });
    });

    // ------------------------ Transfer ------------------------//
    Route::middleware('auth')->prefix('transfer')->group(function () {
        Route::controller(TransferController::class)->group(function () {
            Route::get('list', 'list')->name('transfer/list');
            Route::get('add', 'add')->name('transfer/add');
            Route::get('import', 'import')->name('transfer/import');
        });
    });
    // ------------------------ Application ------------------------//
    Route::middleware('auth')->prefix('application')->group(function () {
        Route::controller(ApplicationController::class)->group(function () {
            Route::get('chat', 'chat')->name('application/chat');
            Route::get('calendar', 'calendar')->name('application/calendar');
            Route::get('email', 'email')->name('application/email');
        });
    });
    // ------------------------- User -----------------------------//
    Route::middleware('auth')->prefix('user')->group(function () {
        Route::controller(UserController::class)->group(function () {
            Route::get('list', 'list')->name('user/list');
            Route::get('new', 'new')->name('user/new');
        });
    });
    // ----------------------- Settings ----------------------------//
    Route::middleware('auth')->prefix('setting')->group(function () {
        Route::controller(SettingsController::class)->group(function () {
            Route::get('general', 'general')->name('setting/general');
            Route::get('email', 'email')->name('setting/email');
            Route::get('payment', 'payment')->name('setting/payment');
            Route::get('currency', 'currency')->name('setting/currency');
            Route::get('grouppermissions', 'groupperMissions')->name('setting/grouppermissions');
            Route::get('createpermission', 'createpermission')->name('setting/createpermission');
            Route::get('taxrates', 'taxrates')->name('setting/taxrates');
        });
    });
});
