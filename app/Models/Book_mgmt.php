<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book_mgmt extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'a_day',
        'intarval_id',
        'next_learn_at',
    ];
    
    public function book(){
        return $this->belongsTo(Book::class);
    }
    
    public function intarval(){
         return $this->belongsTo(Intarval::class);
    }
}
