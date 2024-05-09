<?php

use Brackets\LaravelModuleComposerPackage\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::craftablePro('admin');

Route::middleware('craftable-pro-middlewares')->prefix('admin')->name('craftable-pro.')->group(function () {
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('orders/edit/{order}', [OrderController::class, 'edit'])->name('orders.edit');
    Route::match(['put', 'patch'], 'orders/{order}', [OrderController::class, 'update'])->name('orders.update');
    Route::delete('orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
    Route::post('orders/bulk-destroy', [OrderController::class, 'bulkDestroy'])->name('orders.bulk-destroy');
});
