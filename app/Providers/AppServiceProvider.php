<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //namespace uses MariaDB with causes:
        //Syntax error or access violation:  Specified key was too long
        //to fix it we add this line
        Schema::defaultStringLength(191);
    }
}
