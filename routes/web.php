<?php


use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CylinderCategoriesController;
use App\Http\Controllers\DeliveryBoyController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocationController;

use App\Http\Controllers\PermissionController;

use App\Http\Controllers\ProductsController;
use App\Http\Controllers\RolesController;

use App\Http\Controllers\SettingsController;

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});


Route::group(['namespace' => 'App\Http\Controllers\Auth'], function () {
    // -----------------------------login----------------------------------------//
    Route::controller(LoginController::class)->group(function () {
        Route::get('/login', 'login')->name('login');
        Route::post('/login', 'authenticate');
        Route::get('/logout', 'logout')->name('logout');
        Route::get('logout/page', 'logoutPage')->name('logout/page');
    });
});
Route::controller(HomeController::class)->group(function () {
    Route::get('/home', 'index')->name('home');
    Route::get('profile', 'profile')->name('profile');
    Route::put('profile', 'profile_update')->name('profile.update');
    Route::put('profile-image', 'profile_image_update')->name('profile.image.update');
});
Route::group(['namespace' => 'App\Http\Controllers'], function () {



    // ------------------------- User -----------------------------//
    Route::middleware('auth')->prefix('user')->group(function () {

        Route::get('super-admin', [UserController::class, 'superAdmin'])->name('user.superadmin')->middleware();
        Route::get('sub-admin', [UserController::class, 'subAdmin'])->name('user.subadmin')->middleware();

        Route::get('super-admin/create', [UserController::class, 'createSuperAdmin'])->name('user.superadmin.create')->middleware();
        Route::get('sub-admin/create', [UserController::class, 'createSubAdmin'])->name('user.subadmin.create')->middleware();

        Route::get('super-admin/edit/{id}', [UserController::class, 'editSuperAdmin'])->name('user.superadmin.edit');
        Route::get('sub-admin/edit/{id}', [UserController::class, 'editSubAdmin'])->name('user.subadmin.edit');

        Route::get('permissions/sub-admin/{id}', [UserController::class, 'permissionsSubAdmin'])->name('user.permissions.subadmin');
        Route::post('permissions/assign', [UserController::class, 'assignPermissions'])->name('user.permission.assign');
        Route::post('status-update', [UserController::class, 'updateStatus'])->name('user.status.update');
        Route::post('store', [UserController::class, 'store'])->name('user.store');
        Route::get('edit/{id}', [UserController::class, 'edit'])->name('user.edit');
        Route::put('update/{id}', [UserController::class, 'update'])->name('user.update');
    });

    //--------------------------Delivery Boys/Van Boys---------------------------//
    Route::middleware('auth')->prefix('delivery-boy')->group(function () {
        Route::get('list', [DeliveryBoyController::class, 'index'])->name('delivery-boy.list');
        Route::get('create', [DeliveryBoyController::class, 'create'])->name('delivery-boy.create');
        Route::post('store', [DeliveryBoyController::class, 'store'])->name('delivery-boy.store');
        Route::get('edit/{id}', [DeliveryBoyController::class, 'edit'])->name('delivery-boy.edit');
        Route::put('update/{id}', [DeliveryBoyController::class, 'update'])->name('delivery-boy.update');
        Route::post('status-update', [DeliveryBoyController::class, 'updateStatus'])->name('delivery-boy.status.update');
    });

    //---------------------------Cylinder Categories-------------------------------//
    Route::middleware('auth')->prefix('cylinder-category')->group(function () {
        Route::get('list', [CylinderCategoriesController::class, 'index'])->name('cylinder-category.list');
        Route::post('store', [CylinderCategoriesController::class, 'store'])->name('cylinder-category.store');
        Route::put('update/{id}', [CylinderCategoriesController::class, 'update'])->name('cylinder-category.update');
        Route::post('status-update', [CylinderCategoriesController::class, 'updateStatus'])->name('cylinder-category.status.update');
    });

    //----------------------------Products----------------------------------------//
    Route::middleware('auth')->prefix('products')->group(function () {
        Route::get('list', [ProductsController::class, 'index'])->name('products.list');
        Route::get('create', [ProductsController::class, 'create'])->name('products.create');
        Route::post('store', [ProductsController::class, 'store'])->name('products.store');
        Route::get('edit/{id}', [ProductsController::class, 'edit'])->name('products.edit');
        Route::put('update/{id}', [ProductsController::class, 'update'])->name('products.update');
        Route::post('status-update', [ProductsController::class, 'updateStatus'])->name('products.status.update');
        Route::post('{id}/stock', [ProductsController::class, 'updateStock'])->name('products.stock.update');
    });

    //--------------------------Location---------------------------//
    Route::middleware('auth')->prefix('location')->group(function () {
        Route::get('list', [LocationController::class, 'index'])->name('location.list');
        Route::get('create', [LocationController::class, 'create'])->name('location.create');
        Route::post('store', [LocationController::class, 'store'])->name('location.store');
        Route::get('edit/{id}', [LocationController::class, 'edit'])->name('location.edit');
        Route::put('update/{id}', [LocationController::class, 'update'])->name('location.update');
    });

    //------------------------------New Connection---------------------------//

    Route::middleware('auth')->prefix('new-connection')->group(function () {
        Route::get('customers', [CustomerController::class, 'index'])->name('customers.index');
        Route::post('customers', [CustomerController::class, 'store'])->name('customers.store');
        Route::put('customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');
        // Route::resource('customers', CustomerController::class);
        Route::post('customer/status-update', [CustomerController::class, 'customerStatusUpdate'])->name('customer.status.update');
    });


    // ----------------------- Settings ----------------------------//

    Route::middleware('auth')->prefix('settings')->group(function () {
        Route::get('list', [SettingsController::class, 'index'])->name('settings.list');
        Route::get('create', [SettingsController::class, 'create'])->name('settings.create');
        Route::post('store', [SettingsController::class, 'store'])->name('settings.store');
        Route::get('show/{id}', [SettingsController::class, 'show'])->name('settings.show');
        Route::get('edit/{id}', [SettingsController::class, 'edit'])->name('settings.edit');
        Route::put('update/{id}', [SettingsController::class, 'update'])->name('settings.update');
        Route::delete('delete/{id}', [SettingsController::class, 'destroy'])->name('settings.destroy');
    });

    // Roles and permission
    Route::middleware('auth')->prefix('permission')->group(function () {
        Route::get('list', [PermissionController::class, 'index'])->name('permission.list');
        Route::get('create', [PermissionController::class, 'create'])->name('permission.create');
        Route::post('store', [PermissionController::class, 'store'])->name('permission.store');
        Route::get('show/{id}', [PermissionController::class, 'show'])->name('permission.show');
        Route::get('edit/{id}', [PermissionController::class, 'edit'])->name('permission.edit');
        Route::put('update/{id}', [PermissionController::class, 'update'])->name('permission.update');
        Route::delete('delete/{id}', [PermissionController::class, 'destroy'])->name('permission.destroy');
    });

    Route::middleware('auth')->prefix('role')->group(function () {
        Route::get('list', [RolesController::class, 'index'])->name('roles.list');
        Route::get('create', [RolesController::class, 'create'])->name('roles.create');
        Route::post('store', [RolesController::class, 'store'])->name('roles.store');
        Route::get('show/{id}', [RolesController::class, 'show'])->name('roles.show');
        Route::get('edit/{id}', [RolesController::class, 'edit'])->name('roles.edit');
        Route::post('update/{id}', [RolesController::class, 'update'])->name('roles.update');
        Route::delete('delete/{id}', [RolesController::class, 'destroy'])->name('role.destroy');
    });
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
