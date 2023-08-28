<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Support\Facades\Auth;

final class Log extends Model
{
    use HasFactory;
    use Sortable;

    protected $fillable = [
        'book_id',
        'number',
        'comprehension_id',
        'learned_at',
        'scheduled_at',
        'comment',
    ];
    
    public $sortable = ['comprehension_id', 'learned_at'];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function comprehension()
    {
        return $this->belongsTo(Comprehension::class);
    }
    
    public function subjectSortable($query, $direction)
    {
        return $query->leftJoin('books', 'books.id', '=', 'logs.book_id')
              ->select('logs.*')
              ->orderBy('books.subject_id', $direction);
    }
    
    public function learned_logs(){
        return $this::whereHas('book', function ($query) {
            $query->where('user_id', Auth::id());
        })->whereNotNull('learned_at');
    }
}
