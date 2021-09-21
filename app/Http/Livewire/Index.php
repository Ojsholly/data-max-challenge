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

    public function render()
    {
        $request = Request::create("/api/books", 'GET', [
            'asc' => $this->asc,
            'page' => $this->page,
            'orderBy' => $this->orderBy,
        ]);

        $books = call($request);

        $this->books = $books->data;

        return view('livewire.index', ['books' => $books]);
    }

    public function findBook(int $id)
    {
        $request = Request::create("/api/books/$id", "GET");

        return call($request)->data;
    }

    public function editBook(int $id)
    {
        $book = $this->findBook($id);

        return redirect(config('app.url') . '/edit/' . $book->id);
    }

    public function confirmDelete(int $id): void
    {
        $book = $this->findBook($id);

        $this->dispatchBrowserEvent('swal:confirm', [
            'title' => "Delete Book",
            'text' => "Delete " . $book->name . "?",
            'book' => $book
        ]);
    }

    public function delete(int $id): void
    {
        $request = Request::create("/api/books/$id", "DELETE");

        $delete = call($request);

        $response = $delete->data;

        if ($delete->status_code != 200) {
            $this->dispatchBrowserEvent('swal:error', ['response' => $response, 'message' => $delete->message]);
        }

        $this->dispatchBrowserEvent('swal:success', ['response' => $response, 'message' => $delete->message]);
    }
}