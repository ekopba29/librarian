<?php

use App\Http\Controllers\Admin\ManageBooksController;
use App\Http\Controllers\Admin\ManageBorrowsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Authenticate;
use App\Http\Controllers\Borrower\BookController;
use App\Http\Controllers\Borrower\BorrowController;
use Illuminate\Support\Facades\Request as FacadesRequest;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/request-token', [Authenticate::class,'getToken'])->name('requestToken');
Route::post('/register-user', [Authenticate::class,'registerUser'])->name('registerUser');


Route::middleware('auth:sanctum')->group(function () {
    Route::middleware('admin')->group(function () {
        Route::get('/insider/borrows/request',[ManageBorrowsController::class,'requestIndex'])->name('insider.borrows.request');
        Route::get('/insider/borrows/{borrow}/approve',[ManageBorrowsController::class,'approving'])->name('insider.borrows.approving');
        Route::get('/insider/borrows/{borrow}/borrowed',[ManageBorrowsController::class,'borrowed'])->name('insider.borrows.borrowed');
        Route::get('/insider/borrows/{borrow}/returned',[ManageBorrowsController::class,'returned'])->name('insider.borrows.returned');
        Route::get('/insider/borrows/approved',[ManageBorrowsController::class,'approvedIndex'])->name('insider.borrows.approved');
        Route::get('/insider/borrows/borrowed',[ManageBorrowsController::class,'borrowedIndex'])->name('insider.borrows.borrowed');
        Route::get('/insider/borrows/returned',[ManageBorrowsController::class,'returnedIndex'])->name('insider.borrows.returned');
        
        Route::get('/insider/books/',[ManageBooksController::class,'index'])->name('insider.books.store');
        Route::get('/insider/books/{book}',[ManageBooksController::class,'show'])->name('insider.books.show');
        Route::post('/insider/books/',[ManageBooksController::class,'store'])->name('insider.books.store');
        Route::put('/insider/books/{book}',[ManageBooksController::class,'update'])->name('insider.books.update');
        Route::delete('/insider/books/{book}',[ManageBooksController::class,'destroy'])->name('insider.books.destroy');
    });
    
    Route::middleware('borrower')->group(function () {
        Route::get('borrower/books',[BookController::class,'index'])->name('borrower.books');
        Route::get('borrower/borrowed',[BorrowController::class,'index'])->name('borrower.borrowed');
        Route::get('borrower/borrow/{book}',[BorrowController::class,'store'])->name('borrower.borrow.store');
        Route::get('borrower/borrow/{borrow}/cancel',[BorrowController::class,'storeCancel'])->name('borrower.borrow.cancel');
    });
});
