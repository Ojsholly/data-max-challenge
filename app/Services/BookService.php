<?php

namespace App\Services;

use App\Models\Book;
use App\Exceptions\BookNotCreatedException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

    public function find(array $data): Book
    {
        $book = Book::where($data)->first();

        throw_if(!$book, new ModelNotFoundException());

        return $book;
    }

    public function update(array $data, int $id): Book
    {
        $book = $this->find(['id' => $id]);

        $book->update($data);

        return $book;
    }
}