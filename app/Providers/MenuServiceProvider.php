<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $adminSideMenuJson = file_get_contents(base_path('resources/data/menu-data/adminSideMenu.json'));
        $adminSideMenuData = json_decode($adminSideMenuJson);
        $userSideMenuJson = file_get_contents(base_path('resources/data/menu-data/userSideMenu.json'));
        $userSideMenuData = json_decode($userSideMenuJson);

        // Share all menuData to all the views
        \View::share('menuData',[$adminSideMenuData, $userSideMenuData]);
    }
}
