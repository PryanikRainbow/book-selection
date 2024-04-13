<?php

namespace App\Http\Requests;

class UpdateBookRequest extends BookRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules       = parent::rules();
        $rules['id'] = 'required|exists:books,id';

        return $rules;
    }
}
