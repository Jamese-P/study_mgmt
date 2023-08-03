<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Comprehension extends Model
{
    use HasFactory;

    public function logs()
    {
        return $this->hasMany(Log::class);
    }
}
