<?php

namespace App\Providers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\album;
use Illuminate\Support\Facades\View;
use App\locations;
use App\Events;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        $albums = new album;
        View::share('latestAlbum', $albums->take(4)->get());
        $locations = new locations;
        View::share('locationFooter',$locations->take(6)->get());
        $event = new Events;
        View::share('eventsMenu',$event->take(5)->get());

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
