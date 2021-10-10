<?php

namespace App\Http\Controllers\Borrower;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\Status;
use App\Http\MyService\BookService;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Http\MyService\ResponseService;
use App\Http\Resources\BorrowerResource;
use App\Http\Resources\BorrowsResource;
use Symfony\Component\HttpFoundation\Response;

class BorrowController extends Controller
{
    public function index()
    {
        $book = BookService::getBorrowedBookByIdUser(auth()->user()->id);
        $collectionBook = [
            "borrows" => collect(BorrowerResource::collection($book))->toArray()
        ];
        return ResponseService::wrapStatus(Response::HTTP_OK, true, $collectionBook);
    }

    public function store($book)
    {
        $book = BookService::findBookById($book);
        if (!$book) {
            return ResponseService::notFoundStatus();
        }

        $inStock = BookService::inStock($book->id);
        if (!$inStock) {
            return ResponseService::wrapStatus(Response::HTTP_NOT_IMPLEMENTED, false, null, 'Out Of Stock');
        }

        $borrow = Borrow::create(
            [
                'user_id' => auth()->user()->id,
                'book_id' => $book->id,
                'latest_status' => Status::STATUS_REQUEST
            ]
        );

        $borrow->borrowLogs()->create(
            ['status' => Status::STATUS_REQUEST]
        );

        BookService::changeStock($book->id, "decrease");

        return ResponseService::wrapStatus(Response::HTTP_OK, true, null, 'Request Borrow Success, Waiting for Approval');
    }

    public function storeCancel($borrow)
    {
        $borrow = Borrow::find($borrow);

        if (!$borrow || $borrow->user_id != auth()->user()->id) {
            return ResponseService::notFoundStatus();
        }

        if ($borrow->latest_status == Status::STATUS_REQUEST) {
            $borrow->borrowLogs()->create(['status' => Status::STATUS_CANCELLED]);
            $borrow->update(['latest_status' => Status::STATUS_CANCELLED]);
            BookService::changeStock($borrow->book_id, "increase");
            return ResponseService::wrapStatus(Response::HTTP_OK, true, null, 'Cancelled');
        }
        return ResponseService::wrapStatus(Response::HTTP_NOT_FOUND, false, null, 'Data Not Found');
    }
}
