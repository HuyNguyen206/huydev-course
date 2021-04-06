<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

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
        //
        Blade::if('hasStartSeries', function ($seriesId){
            return auth()->user()->hasStartSeries($seriesId);
        });

        Blade::if('admin', function (){
            return auth()->user()->isAdmin();
        });

        Blade::if('isSubcribe', function ($user){
            return $user->subscribed('default');
        });
    }
}
