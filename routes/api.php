<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TraitsController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', [AuthController::class, 'login'])->name('auth.login');
Route::post('admin_create', [AuthController::class, 'create_admin'])->name('auth.create_admin');

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('authorization')->group(function() {
    Route::prefix('users')->group(function() {
        Route::post('/create', [UserController::class, 'store'])->name('users.store');

    });

    Route::prefix('traits')->group(function() {
        Route::post('/import_data', [TraitsController::class, 'import_excel'])->name('traits.import_excel');
        Route::get('/get_traits', [TraitsController::class, 'index'])->name('traits.index');
    });

    Route::prefix('master_gecko')->group(function() {
        Route::post('/create', [TraitsController::class, 'import_excel'])->name('master_gecko.import_excel');
        Route::get('/get_data/{id?}', [TraitsController::class, 'index'])->name('master_gecko.index');
    });
});
