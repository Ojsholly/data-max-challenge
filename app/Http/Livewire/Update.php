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
        $this->name = $book->data->name;
        $this->isbn = $book->data->isbn;
        $this->authors = implode(", ", $book->data->authors);
        $this->country = $book->data->country;
        $this->publisher = $book->data->country;
        $this->number_of_pages = $book->data->number_of_pages;
        $this->publisher = $book->data->publisher;
        $this->release_date = $book->data->release_date;
        $this->book_id = $book->data->id;
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

        $request->headers->set('accept', 'application/json');

        $update = app()->handle($request);

        $response = $update->getContent();

        if ($update->status() != 200) {

            $this->dispatchBrowserEvent('swal:error', ['response' => json_decode($response)]);
            return false;
        }

        $this->dispatchBrowserEvent('swal:success', ['response' => json_decode($response)]);
    }
}
