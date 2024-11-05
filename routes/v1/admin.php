<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ActionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PackageController;

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
    //categories
    Route::apiResource('category', CategoryController::class);
    Route::post('category-status-update', [ActionController::class, 'categoryStatusUpdate']);
    //services
    Route::apiResource('service', ServiceController::class);
    Route::post('service-status-update', [ActionController::class, 'serviceStatusUpdate']);
    //packages
    Route::apiResource('package', PackageController::class);
    Route::post('package-status-update', [ActionController::class, 'packageStatusUpdate']);

    


// });