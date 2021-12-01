<?php

namespace App\Http\Controllers\Admin;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\MyService\BookService;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Http\MyService\ResponseService;
use App\Http\Requests\ManageBookRequest;
use Symfony\Component\HttpFoundation\Response;

class ManageBooksController extends Controller
{
    public function index()
    {
        $book = Book::all();
        $collectionBook = [
            "book" => collect(BookResource::collection($book))->toArray()
        ];

        return ResponseService::wrapStatus(Response::HTTP_OK, true, $collectionBook);
    }

    public function store(ManageBookRequest $request)
    {
        $book = Book::create($request->toArray());

        return ResponseService::wrapStatus(
            Response::HTTP_OK,
            true,
            $book->only('judul', 'deskripsi', 'stock', 'id', 'pengarang','category')
        );
    }

    public function update(ManageBookRequest $request, $book_id)
    {
        $book = BookService::findBookById($book_id);
        $this->isBookFounded($book);
        $book->update($request->toArray());
        return ResponseService::wrapStatus(
            Response::HTTP_OK,
            true,
            $book->refresh()->only('judul', 'deskripsi', 'stock', 'id', 'pengarang','category')
        );
    }

    public function destroy($book_id)
    {
        $book = BookService::findBookById($book_id);
        $this->isBookFounded($book);
        $delete = $book->delete();

        $httpStatus = ($delete) ? Response::HTTP_OK : Response::HTTP_UNPROCESSABLE_ENTITY;
        $message = ($delete) ? "Success Delete" : "Fail Delete";
        return ResponseService::wrapStatus(
            $httpStatus,
            $delete,
            null,
            $message
        );
    }

    private function isBookFounded($book)
    {
        if (!$book) {
            return ResponseService::notFoundStatus();
        }
    }

    public function show($book)
    {
        $book_id = $book;
        $book = BookService::findBookById($book_id);
        $this->isBookFounded($book_id);
        return ResponseService::wrapStatus(
            Response::HTTP_OK,
            true,
            $book->refresh()->only('judul', 'deskripsi', 'stock', 'id', 'pengarang','category')
        );
    }
}
