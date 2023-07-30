<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comprehension extends Model
{
    use HasFactory;
    
    public function logs()
    {
        return $this->hasMany(Log::class);
    }
}
