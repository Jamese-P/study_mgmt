<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'subject_id',
        'type_id',
        'max',
        'a_day',
        'intarval_id',
        'next_learn_at',
    ];

    public function logs()
    {
        return $this->hasMany(Log::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function intarval()
    {
        return $this->belongsTo(Intarval::class);
    }
}
