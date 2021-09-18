<?php

namespace App\Services;

use App\Exceptions\BookNotCreatedException;
use App\Models\Book;

class BookService
{
    public function store(array $data): Book
    {
        $book = Book::create($data);

        throw_if(!$book, new BookNotCreatedException($data));

        return $book;
    }
}