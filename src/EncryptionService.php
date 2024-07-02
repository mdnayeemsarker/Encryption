<?php

namespace Mdnayeemsarker\Encryption;

use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Facades\Log;

class EncryptionService
{
    protected $encrypter;
    protected $isDebug;

    public function __construct()
    {
        $keyBase = 'Asha@Bizli#01714466';
        $key = substr(hash('sha256', $keyBase, true), 0, 32);
        $cipher = 'AES-256-CBC';
        $iv = str_repeat(chr(0), 16);
        $this->encrypter = new Encrypter($key, $cipher, $iv);
    }
    public function encrypt($data)
    {
        try {
            $encrypted = $this->encrypter->encrypt($data);
            if ($this->isDebug) {
                Log::info('Data Encryption: ' . $encrypted);
            }
            return $encrypted;
        } catch (\Illuminate\Contracts\Encryption\EncryptException $e) {
            if ($this->isDebug) {
                Log::error('Encryption failed: ' . $e->getMessage());
            }
            return 'error';
        }
    }

    public function decrypt($data)
    {
        try {
            $decrypted = $this->encrypter->decrypt($data);
            if ($this->isDebug) {
                Log::info('Data Decryption: ' . $decrypted);
            }
            return $decrypted;
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            if ($this->isDebug) {
                Log::error('Decryption failed: ' . $e->getMessage());
            }
            return null;
        }
    }
}