<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'number',
        'comprehension_id',
        'learned_at',
        'passed_at',
        'comment',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function comprehension()
    {
        return $this->belongsTo(Comprehension::class);
    }
    
}
