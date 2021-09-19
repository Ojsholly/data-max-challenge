<?php

namespace App\Http\Requests\Book;

use Intervention\Validation\Rules\Isbn;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'isbn' => ['required', 'unique:books,isbn', new Isbn()],
            'authors' => 'required|array',
            'authors.*' => 'required|string',
            'country' => 'required|string',
            'number_of_pages' => 'required|integer|min:1',
            'publisher' => 'required|string',
            'release_date' => 'required|date|date_format:Y-m-d'
        ];
    }
}