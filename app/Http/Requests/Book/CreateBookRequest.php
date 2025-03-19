<?php

namespace App\Http\Requests\Book;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class CreateBookRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:255',
            ],
            'description' => [
                'required',
                'string',
            ],
            'edition' => [
                'nullable',
                'integer',
                'min:1',
            ],
            'release_date' => [
                'required',
                'date',
            ],
            'publisher' => [
                'required',
                'string',
                'max:255',
            ],
            'format' => [
                'required',
                'string',
            ],
            'pages' => [
                'required',
                'integer',
                'min:1',
            ],
            'country' => [
                'required',
                'string',
                'max:255',
            ],
            'ISBN' => [
                'required',
                'string',
                'max:13',
                Rule::unique('books', 'ISBN'),
            ],

            'authors' => [
                'required',
                'array',
            ],

            'authors.*' => [
                'required',
                'string',
                'max:255',
            ],

            'genres' => [
                'required',
                'array',
            ],

            'genres.*' => [
                'required',
                'string',
            ],
        ];
    }
}
