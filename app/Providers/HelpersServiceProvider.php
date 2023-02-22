<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HelpersServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        require_once app_path() . '/Helpers/HashCreatedHelper.php';
        require_once app_path() . '/Helpers/UrlCreatedHelper.php';
        require_once app_path() . '/Helpers/ResponseHelper.php';

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
