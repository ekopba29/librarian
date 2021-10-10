<?php

namespace App\Http\MyService;

use App\Models\Book;
use App\Models\Borrow;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class BookService
{

    public static function changeStock(int $book_id, string $action)
    {
        $book = Book::findOrFail($book_id);
        switch ($action) {
            case 'increase':
                $calculation = $book->stock + 1;
                break;

            case 'decrease':
                $calculation = $book->stock - 1;
                break;
        }
        $book->update(['stock' => $calculation]);
    }

    public  static function inStock(int $book_id)
    {
        $book = Book::findOrFail($book_id);
        return $book->stock > 0 ? true : false;
    }

    public static function findBookById(int $book_id)
    {
        $book = Book::find($book_id);
        if (!$book) {
            return false;
        }
        return $book;
    }

    public static function getBorrowedBookByIdUser(int $id_user)
    {
        return Borrow::with(['book', 'user'])->where('user_id', $id_user)->get();
    }
}
