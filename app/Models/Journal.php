<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Journal extends Model
{
    use HasFactory;

    /**
     * table information
     *
     * @var string $table>
     */
    protected $table = 'journals';
    /** @var string $primaryKey */
    protected $primaryKey = 'journal_id';

    /**
     * Index information
     *
     * @var string $keyType>
     */
    protected $keyType = 'string';
    /** @var bool $incrementing */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'journal_id',
        'user_id',
        'title',
        'body',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function DailyUploadCheck() {
        $twentyFourHoursAgo = Carbon::now()->subDay();

        $item = $this->where('user_id', Auth::user()->user_id)
                ->where('created_at', '>', $twentyFourHoursAgo)
                ->first();

        return $item !== null;
    }
}
