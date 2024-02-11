<?php

use App\Http\Controllers\CategoryExpensesController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ExpenseRequestController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UsersController;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
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
    // Artisan::call('migrate:fresh');
    return view('auth.login');
});
// Route::get('/register', function () {
//     return redirect('/');
// });

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $auth_user = User::find(auth()->user()->id);
        // $roles = $auth_user->roles->toArray();
        return view('welcome');
    })->name('dashboard');

    Route::prefix('facturation_gestion_financiere')->group(function () {
        Route::get('expenses/create/{req}', [ExpenseController::class, 'create'])->name('expense_create');
        Route::resource('expenses', ExpenseController::class)->except('create');
        Route::resource('categ_expenses', CategoryExpensesController::class);
        Route::resource('expenses_requests', ExpenseRequestController::class);
        Route::put('validate_expense_request', [ExpenseRequestController::class, 'validateExpense'])->name('validate_expense_request');
    });
    Route::prefix('gestion_utilisateur')->group(function () {
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);
        Route::resource('users', UsersController::class);
        Route::post('/password-update-request', [UsersController::class, 'passwordUpdateRequest'])->name('password_update_request');
        Route::get('update-password', function () {
            return view('auth.reset-password');
        })->name('update-password');
        Route::post('reset_password', [UsersController::class, 'reset_password'])->name('reset_password');
        Route::get('user/verify/{token}', [UsersController::class, 'verifyUser']);
    });
});
