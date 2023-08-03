<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Type extends Model
{
    use HasFactory;

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
