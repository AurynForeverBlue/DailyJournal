<?php

namespace App\Models;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log;

class Security extends User
{
    use HasFactory;

    public function encryptValue($value)
    {
        $encryptedValue = Crypt::encryptString($value);
        return $encryptedValue;
    }

    public function decryptValue($encryptedValue)
    {
        try {
            $decryptedValue = Crypt::decryptString($encryptedValue);
            return $decryptedValue;
        } catch (DecryptException $e) {
            Log::debug($e);
            return false;
        }
    }
}
