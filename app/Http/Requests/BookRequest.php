<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'call_number' => 'required',
            'title' => 'required',
            'copy' => 'required|numeric|min:1',
            'publish_place' => 'required',
            'publisher' => 'required',
            'isbn_issn' => 'required'
        ];
    }
}
