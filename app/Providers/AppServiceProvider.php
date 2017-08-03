<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('layouts.search', function ($view) {
            $view->with('ad159', get_ads(159));
        });
        view()->composer('layouts.nav', function ($view) {
            $view->with('category', get_category());
            $view->with('middle_nav', get_nav('middle'));
        });
        view()->composer('layouts.footer', function ($view) {
            $view->with('nav_bottom', get_nav('bottom'));
            $view->with('article_cat', get_article_cat());
        });
        view()->composer('layouts.user_menu', function ($view) {
            $view->with('user_menu1', get_nav('user1'));
            $view->with('user_menu2', get_nav('user2'));
        });
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
