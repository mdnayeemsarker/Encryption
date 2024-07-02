<?php

namespace Mdnayeemsarker\Encryption;

use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class NHelper
{
    protected $encrypter;
    protected $isDebug;

    public function __construct()
    {
        // $keyBase = 'Abmn@!0171#Asha@Bizli#MP1234';
        $keyBase = Config::get('app.nenc_key');
        $key = substr(hash('sha256', $keyBase, true), 0, 32);
        $cipher = 'AES-256-CBC';
        $iv = str_repeat(chr(0), 16);
        $this->encrypter = new Encrypter($key, $cipher, $iv);
        $this->isDebug = Config::get('app.nenc_is_debug', false);
    }
    public function checkKey() {
        return Config::get('app.nenc_key');
    }
    public function checkDebug() {
        return Config::get('app.nenc_is_debug');
    }
    public function encryption($data)
    {
        try {
            $encrypted = $this->encrypter->encrypt($data);
            if ($this->isDebug) {
                Log::info('NENC Encryption: ' . $encrypted);
            }
            return $encrypted;
        } catch (\Illuminate\Contracts\Encryption\EncryptException $e) {
            if ($this->isDebug) {
                Log::error('NENC Encryption failed: ' . $e->getMessage());
            }
            return 'error';
        }
    }

    public function decryption($data)
    {
        try {
            $decrypted = $this->encrypter->decrypt($data);
            if ($this->isDebug) {
                Log::info('NENC Decryption: ' . $decrypted);
            }
            return $decrypted;
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            if ($this->isDebug) {
                Log::error('NENC Decryption failed: ' . $e->getMessage());
            }
            return null;
        }
    }
}