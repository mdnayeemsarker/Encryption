<?php

namespace Mdnayeemsarker\Encryption\Providers;
use Mdnayeemsarker\Encryption\NHelper;

use Illuminate\Support\ServiceProvider;

class EncryptionServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(NHelper::class, function ($app) {
            return new NHelper();
        });
    }

    public function boot()
    {
        // Optional booting logic
    }
}