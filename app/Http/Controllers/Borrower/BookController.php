<?php

namespace App\Http\Controllers\Borrower;

use App\Http\Controllers\Controller;
use App\Http\MyService\ResponseService;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BookController extends Controller
{
    public function index()
    {
        $book = Book::where('stock', '>', 0)->get();

        $collectionBook = [
            "book" => collect(BookResource::collection($book))->toArray()
        ];
        
        return ResponseService::wrapStatus(Response::HTTP_OK, true, $collectionBook);
    }
}
