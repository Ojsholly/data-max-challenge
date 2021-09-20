<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

class Index extends Component
{

    public $search;
    public $perPage = 10;
    public $asc = true;
    public $page = 1;
    public $orderBy = "name";
    public $books;

    protected $listeners = ['delete'];

    public function dispatchRequest($request)
    {
        return Route::dispatch($request);
    }

    public function render()
    {
        $request = Request::create("/api/books", 'GET', [
            'asc' => $this->asc,
            'page' => $this->page,
            'orderBy' => $this->orderBy,
        ]);

        $books = $this->dispatchRequest($request)->getData();

        $this->books = collect($books->data);

        return view('livewire.index');
    }

    public function confirmDelete(int $id)
    {
        $request = Request::create("/api/books/$id", "GET");

        $book = $this->dispatchRequest($request)->getData();

        $this->dispatchBrowserEvent('swal:confirm', [
            'title' => "Delete Book",
            'text' => "Delete " . $book->data->name . "?",
            'book' => $book->data
        ]);
    }

    public function delete(int $id)
    {
        $request = Request::create("/api/books/$id", "DELETE");

        $book = $this->dispatchRequest($request);
    }
}