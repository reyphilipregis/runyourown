<?php

use App\Http\Controllers\BillsController;
use App\Http\Controllers\SitesController;
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

Route::get('/', [SitesController::class, 'index']);
Route::get('/sites/{id}', [SitesController::class, 'detailView']);
Route::get('/sites', [SitesController::class, 'index']);
Route::get('/bills', [BillsController::class, 'index']);

Route::get('/run-migrations-seeds', function () {
    Artisan::call('optimize:clear');
    Artisan::call('migrate:refresh --seed');

    return 'Migrations executed succcessfully!';
});
