<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Book_mgmtRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'book_mgmt.a_day' => 'required|gte:1',
            //'book_mgmt.next' => 'required|gte:1',
            //'book_mgmt.next_learn_at' => 'required|date|after:yesterday',
            'book_mgmt.next_learn_at' => 'required|date',
        ];
    }
}
