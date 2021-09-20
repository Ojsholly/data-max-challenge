<?php

namespace App\Services;

use App\Models\Book;
use App\Exceptions\BookNotCreatedException;
use App\Exceptions\BookNotDeletedException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;

class BookService
{
    public function store(array $data): Book
    {
        $book = Book::create($data);

        throw_if(!$book, new BookNotCreatedException($data));

        return $book;
    }

    public function search(array $data): LengthAwarePaginator
    {
        return Book::search($data['search'] ?? '')
            ->orderBy($params['orderBy'] ?? 'id', $params['asc'] ?? true ? 'asc' : 'desc')
            ->paginate($data['perPage'] ?? 10, ['*'], 'page', $data['page'] ?? 1);
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

    public function delete(array $data): bool
    {
        $book = $this->find($data);

        $book = $book->delete();

        throw_if(!$book, new BookNotDeletedException($data));

        return $book;
    }
}