<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * table information
     *
     * @var string $table>
     */
    protected $table = 'users';
    /** @var string $primaryKey */
    protected $primaryKey = 'user_id';

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
        'user_id',
        'username',
        'email',
        'password',
        'file_type'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'file_type' => 'json'
    ];

    protected $file_types = [
        "pfphoto",
        "banner"
    ];

    public function UpdateFileType($file_name = "standard", $file_type = "jpg") {
        $file_type = [
            "file_name" => $file_name,
            "file_type" => $file_type,
        ];

        return $file_type;
    }

    public function getRemainingFileTypes($current_file_type) {
        $remaining_types = [];
        foreach ($this->file_types as $type) {
            if ($type != $current_file_type) {
                array_push($remaining_types, $type);
            }
        }

        return $remaining_types;
    }

    public function uploadFile($disk, $location, $filename, $file) {
        Storage::disk($disk)->put($location. $filename, file_get_contents($file));
    }

    public function deleteFile($disk, $location, $filename) {
        Storage::disk($disk)->delete($location. $filename);
    }

    public function updateFile($disk, $location, $file, $new_filename, $old_filename = "standard.jpg") {
        if ($old_filename != "standard.jpg") {
            $this->deleteFile($disk, $location, $old_filename);
        }

        $this->uploadFile($disk, $location, $new_filename, $file);
    }
}