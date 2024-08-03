<?php

use App\Http\Controllers\IncompleteItems\AvIncompleteItemsController;
use App\Http\Controllers\Branches\BranchController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;

// web.php

Route::get('/', [BranchController::class, 'index']);
Route::get('/branch', [AvIncompleteItemsController::class, 'searchByLocationAndItemId']);
Route::get('/branchitems', [AvIncompleteItemsController::class, 'searchByLocationAndItemId']);
Route::put('/branchitems/{id}', [AvIncompleteItemsController::class, 'update'])->name('branchitems.update');

require __DIR__.'/auth.php';
