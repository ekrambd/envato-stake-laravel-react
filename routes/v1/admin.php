<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ActionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PackageController;

//  user action controller
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\WithdrawController;



//user auth
Route::post('user-signup', [AuthController::class, 'userSignup']);
Route::post('user-signin', [AuthController::class, 'userSignin']);
//admin login
Route::post('admin-login', [AuthController::class, 'adminLogin']);

// Route::middleware('auth:sanctum')->group( function () { 
	//user routes
    Route::get('/user-details', [AuthController::class,'userDetails']);
    Route::post('user-signout', [AuthController::class,'userSignout']);
    
    
    //admin routes
    Route::post('admin-logout', [AuthController::class, 'adminLogout']);
    //admin routes group
    Route::group(['prefix'=>'admin','as'=>'admin.'], function(){
        //categories
        Route::apiResource('category', CategoryController::class);
        Route::post('category-status-update', [ActionController::class, 'categoryStatusUpdate']);
        //services
        Route::apiResource('service', ServiceController::class);
        Route::post('service-status-update', [ActionController::class, 'serviceStatusUpdate']);
        //packages
        Route::apiResource('package', PackageController::class);
        Route::post('package-status-update', [ActionController::class, 'packageStatusUpdate']);
    
    });
    
    // user route group
    Route::group(['prefix'=>'user','as'=>'user.'], function(){
        // purchase route
        Route::group(['prefix'=>'purchase','as'=>'purchase.'], function(){
            Route::get('/', [PurchaseController::class, 'index'])->name('index');
            Route::post('/', [PurchaseController::class, 'store'])->name('store');
            Route::get('/{purchase}', [PurchaseController::class, 'show'])->name('show');
        });
         // withdraw route
         Route::group(['prefix'=>'withdraw','as'=>'withdraw.'], function(){
            Route::get('/', [WithdrawController::class, 'index'])->name('index');
            Route::post('/', [WithdrawController::class, 'store'])->name('store');
            Route::get('/{withdraw}', [WithdrawController::class, 'show'])->name('show');
        });
    });

    

// });

// Route::group(['prefix'=>'admin','as'=>'admin.','middleware'=>['auth','admin']], function(){

// });
  