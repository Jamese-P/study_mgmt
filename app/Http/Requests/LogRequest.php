<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LogRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'log.number' => 'required|gte:1',
            'log.book_id' => 'required',
            'log.comprehension_id'=> 'required',
        ];
    }
}
