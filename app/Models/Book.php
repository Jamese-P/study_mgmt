<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'subject_id',
        'type_id',
        'start',
        'max',
    ];

    protected $casts = [
        'max' => 'int',
        'start' => 'int',
    ];

    public function book_mgmt()
    {
        return $this->hasOne(Book_mgmt::class);
    }

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
