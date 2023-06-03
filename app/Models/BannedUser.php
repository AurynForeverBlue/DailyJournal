<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannedUser extends User
{
    use HasFactory;

    /**
     * table information
     *
     * @var string $table>
     */
    protected $table = 'banned_users';
    /** @var string $primaryKey */
    protected $primaryKey = 'ban_id';

    /**
     * Index information
     *
     * @var string $keyType>
     */
    protected $keyType = 'string';
    /** @var bool $incrementing */
    protected $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ban_id',
        'user_id',
        'reason'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
