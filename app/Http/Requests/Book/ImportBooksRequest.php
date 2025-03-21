<?php

namespace App\Http\Requests\Book;

use App\Http\Requests\BaseRequest;

class ImportBooksRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'file' => [
                'required',
                'mimes:csv,txt',
            ],
        ];
    }
}
