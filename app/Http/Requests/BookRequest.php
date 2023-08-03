<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'book.name' => 'required|string|max:100',
            'book.subject_id' => 'required',
            'book.type_id' => 'required',
            'book.max' => 'required|gte:1',
            'book.a_day' => 'required|gte:1',
            'book.intarval_id' => 'required',
            'book.next_learn_at' => 'required|date|after:yesterday',
        ];
    }
}
