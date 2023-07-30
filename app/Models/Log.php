<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;
    
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
    
    public function comprehension()
    {
        return $this->belongsTo(Comprehension::class);
    }
}
