<?php

namespace App\Services;

use App\Models\Book;
use App\Exceptions\BookNotCreatedException;
use Illuminate\Database\Eloquent\Collection;

class BookService
{
    public function store(array $data): Book
    {
        $book = Book::create($data);

        throw_if(!$book, new BookNotCreatedException($data));

        return $book;
    }

    public function search(array $data): Collection
    {
        return Book::search($data)->get();
    }
}