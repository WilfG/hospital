<?php

use App\Http\Controllers\CategoryExpensesController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UsersController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});
Route::get('/register', function () {
    return redirect('/');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $auth_user = User::find(auth()->user()->id);
        // $roles = $auth_user->roles->toArray();
        return view('welcome');
    });

    Route::resource('expenses', ExpenseController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('categ_expenses', CategoryExpensesController::class);
    Route::resource('users', UsersController::class);
    Route::post('/password-update-request', [UsersController::class, 'passwordUpdateRequest'])->name('password_update_request');
    Route::get('update-password', function(){
        return view('auth.reset-password');
    })->name('update-password');
    Route::post('reset_password', [UsersController::class, 'reset_password'])->name('reset_password');
    Route::get('user/verify/{token}', [UsersController::class,'verifyUser']);
        
});
