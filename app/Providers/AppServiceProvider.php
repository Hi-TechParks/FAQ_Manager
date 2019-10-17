<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Setting;
use App\Location;
use App\FaqCategory;
use App\Social;
use View;

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
        Schema::defaultStringLength(191);


        // Share view for Common Data
        $settings = Setting::where('status', '1')->get();
        $location_submenus = Location::where('status', '1')->get();
        $category_submenus = FaqCategory::where('status', '1')->get();
        $socials = Social::where('status', '1')->get();
        $search_locations = Location::where('status', '1')->get();


        View::share(['settings' => $settings, 'location_submenus' => $location_submenus, 'category_submenus' => $category_submenus, 'socials' => $socials, 'search_locations' => $search_locations]);

    }
}
