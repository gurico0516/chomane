<?php

use App\Http\Controllers\AllowanceController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // allowance
    Route::get('/allowance', [AllowanceController::class, 'index'])->name('allowance.index');
    Route::get('/allowance/create', [AllowanceController::class, 'createView'])->name('allowance.createView');
    Route::patch('/allowance/create', [AllowanceController::class, 'create'])->name('allowance.create');
    Route::get('/allowance/edit', [AllowanceController::class, 'editView'])->name('allowance.editView');
    Route::patch('/allowance/edit', [AllowanceController::class, 'edit'])->name('allowance.edit');
    Route::delete('/allowance', [AllowanceController::class, 'delete'])->name('allowance.delete');

    // expense
    Route::get('/expense/create', [ExpenseController::class, 'createView'])->name('expense.createView');
    Route::post('/expense/create', [ExpenseController::class, 'create'])->name('expense.create');
    Route::get('/expense/edit/{expenseId}', [ExpenseController::class, 'editView'])->name('expense.editView');
    Route::post('/expense/edit/{expenseId}', [ExpenseController::class, 'edit'])->name('expense.edit');
    Route::delete('/expense', [ExpenseController::class, 'delete'])->name('expense.delete');
});

require __DIR__.'/auth.php';
