<?php

namespace App\Http\Requests\Book;

use Illuminate\Validation\Rule;
use Intervention\Validation\Rules\Isbn;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
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
            'name' => ['sometimes', 'nullable', 'string', Rule::unique('books')->ignore(request()->route('book'))],
            'isbn' => ['required', new Isbn(), Rule::unique('books')->ignore(request()->route('book'))],
            'authors' => 'sometimes|nullable||array',
            'authors.*' => 'required_with:authors|string',
            'country' => 'sometimes|nullable|string',
            'number_of_pages' => 'sometimes|nullable|integer|min:1',
            'publisher' => 'sometimes|nullable|string',
            'release_date' => 'sometimes|nullable|date|date_format:Y-m-d'
        ];
    }
}