<?php

namespace App\Models;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log;

class Security extends User
{
    use HasFactory;

    /**
     * Encrypts a given string using ...
     *
     * @param string $plaintext The string to encrypt.
     * @return string The encrypted string.
     */
    public function encrypt($plaintext)
    {
        //
    }

    /**
     * Decrypts a given string using ...
     *
     * @param string $encrypted The string to decrypt.
     * @return string|bool The decrypted string, or false on failure.
     */
    public function decrypt($encryptedtext)
    {
        //
    }
}
