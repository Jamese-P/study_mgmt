<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Book_mgmt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'a_day',
        'intarval_id',
        'next',
        'next_learn_at',
    ];

    protected $casts = [
        'a_day' => 'int',
        'next' => 'int',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function intarval()
    {
        return $this->belongsTo(Intarval::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function get_under_progress()
    {
        return $this::where('user_id', Auth::id())->where('next', '!=', '-1')->orderBy('next_learn_at', 'asc');
    }

    public function get_under_progress_byDate(Carbon $day)
    {
        return $this::whereDate('next_learn_at', $day)->where('user_id', Auth::id())->where('next', '!=', '-1')->get();
    }

    public function get_finished()
    {
        return $this::where('user_id', Auth::id())->where('next', '-1')->orderBy('updated_at', 'desc')->get();
    }

    public function get_exp()
    {
        $today = Carbon::today();

        return $this::whereDate('next_learn_at', '<', $today)->where('user_id', Auth::id())->where('next', '!=', '-1')->get();
    }
}
