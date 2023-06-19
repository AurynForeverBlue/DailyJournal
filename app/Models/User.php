<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
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

    /**
     * get current user data from database
     */
    public function getCurrentUser() {
        return Auth::user();
    }

    /**
     * get current user data from database by user_id
     * @param string $user_id
     */
    public function getUser($user_id) {
        return $this->find($user_id);
    }

    /**
     * get current user data from database by user_id
     */
    public function getCurrentModelUser() {
        return $this->getUser($this->getCurrentUser()->user_id); ;
    }

    /**
     * get current user data from database by username
     * @param string $username
     */
    public function getUserWithUsername($username) {
        return $this->where('username', $username)->first();
    }
    
    /**
     * create array with filled in file data
     */
    public function createFileType() {
        return [
            "pfphoto" => $this->UpdateFileType(), 
            "banner" => $this->UpdateFileType()
        ];
    }

    /**
     * get file data from current user
     */
    public function getFileName($type) {
        $current_user = $this->getCurrentUser();
        return $current_user->file_type[$type]["file_name"].".".$current_user->file_type[$type]["file_type"];
    }

    /**
     * update array for file data
     * @param string $file_name = "standard"
     * @param string $file_type = "jpg"
     */
    public function UpdateFileType($file_name = "standard", $file_type = "jpg") {
        $file_type = [
            "file_name" => $file_name,
            "file_type" => $file_type,
        ];

        return $file_type;
    }

    /**
     * get remaining file type data
     * @param string $current_file_type
     */
    public function getRemainingFileTypes($current_file_type) {
        $remaining_types = [];
        foreach ($this->file_types as $type) {
            if ($type != $current_file_type) {
                array_push($remaining_types, $type);
            }
        }

        return $remaining_types;
    }

    /**
     * upload file to project storage
     * @param string $disk
     * @param string $location
     * @param string $filename
     * @param $file
     */
    public function uploadFile($disk, $location, $filename, $file) {
        Storage::disk($disk)->put($location. $filename, file_get_contents($file));
    }

    /**
     * Delete file from project storage
     * @param string $disk
     * @param string $location
     * @param string $filename
     */
    public function deleteFile($disk, $location, $filename) {
        Storage::disk($disk)->delete($location. $filename);
    }

    /**
     * Update file from project storage
     * @param string $disk
     * @param string $location
     * @param string $file
     * @param string $new_filename
     * @param string $old_filename = "standard.jpg"
     */
    public function updateFile($disk, $location, $file, $new_filename, $old_filename = "standard.jpg") {
        if ($old_filename != "standard.jpg") {
            $this->deleteFile($disk, $location, $old_filename);
        }

        $this->uploadFile($disk, $location, $new_filename, $file);
    }
}