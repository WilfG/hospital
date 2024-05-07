<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\CategoryExpensesController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\DrugController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ExpenseRequestController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\PatientsController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UsersController;
use App\Models\ExpenseRequest;
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
        Route::get('demande_de_depense/download/{id}', [ExpenseRequestController::class, 'download'])->name('demande_de_depense');
    });
    Route::prefix('gestion_stock')->group(function () {
        Route::resource('drugs', DrugController::class);
        Route::resource('materiels', MaterialController::class);
        Route::resource('purchases', PurchaseController::class);
        Route::resource('sales', SaleController::class);
        Route::get('/stockmovements', [SaleController::class, 'fiche_stock'])->name('stockmovements');
        Route::get('/fifo_product/{id}', [SaleController::class, 'fiche_fifo_product'])->name('fifo_product');
        Route::get('/fifo_materiel/{id}', [SaleController::class, 'fiche_fifo_materiel'])->name('fifo_materiel');
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

    Route::prefix('gestion_ticket')->group(function () {
        Route::get('/searchticket', [TicketController::class, 'search']);
        
        Route::resource('/tickets', TicketController::class);
        Route::post('/tickets/{ticket}/messages', [TicketController::class, 'addMessage'])->name('tickets.add_message');
    });
    Route::prefix('gestion_patients')->group(function () {
        Route::resource('patients', PatientsController::class);
        Route::resource('consultations', ConsultationController::class);
        Route::resource('appointments', AppointmentController::class);
    });
});
