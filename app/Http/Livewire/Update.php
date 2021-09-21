<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Intervention\Validation\Rules\Isbn;

class Update extends Component
{
    protected $book;
    public $name;
    public $isbn;
    public $authors;
    public $country;
    public $publisher;
    public $number_of_pages;
    public $release_date;
    public $book_id;

    protected function rules()
    {
        return [
            'name' => ['sometimes', 'nullable', 'string', Rule::unique('books')->ignore($this->book_id)],
            'isbn' => ['required', new Isbn(), Rule::unique('books')->ignore($this->book_id)],
            'authors' => 'required|string',
            'country' => 'required|string',
            'number_of_pages' => 'required|integer|min:1',
            'publisher' => 'required|string',
            'release_date' => 'required|date|date_format:Y-m-d|before_or_equal:' . Carbon::yesterday()->format('Y-m-d')
        ];
    }

    public function mount($book)
    {
        $this->name = $book->name;
        $this->isbn = $book->isbn;
        $this->authors = implode(", ", $book->authors);
        $this->country = $book->country;
        $this->publisher = $book->country;
        $this->number_of_pages = $book->number_of_pages;
        $this->publisher = $book->publisher;
        $this->release_date = $book->release_date;
        $this->book_id = $book->id;
    }

    public function updated($field)
    {
        $this->validateOnly($field);
    }

    public function render()
    {
        return view('livewire.update');
    }

    public function update()
    {
        $data = $this->validate();

        $data['authors'] = explode(", ", $data['authors']);

        $request = Request::create("/api/books/" . $this->book_id, "PATCH", $data);

        $update = call($request);

        $response = $update->data;

        if ($update->status_code != 200) {

            $this->dispatchBrowserEvent('swal:error', ['response' => $response, 'message' => $update->message]);
            return false;
        }

        $this->dispatchBrowserEvent('swal:success', ['response' => $response, 'message' => $update->message]);
    }
}