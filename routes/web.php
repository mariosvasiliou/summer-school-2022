<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->middleware('throttle:guest')->name('index');

Auth::routes();
Route::mailPreview();

//auth users only
Route::middleware(['auth'])->group(function () {
    Route::view('/home', 'home')->name('home');
    Route::resource('contacts', ContactController::class);
    Route::resource('users', UserController::class);
    Route::resource('departments', DepartmentController::class);
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/export/pdf/{report}', [ReportController::class, 'exportPDF'])->name('reports.pdf');
    Route::get('reports/export/excel/{report}', [ReportController::class, 'exportExcel'])->name('reports.excel');
});
