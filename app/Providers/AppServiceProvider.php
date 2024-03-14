<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use URL;
use Illuminate\Support\Facades\Blade;

final class AppServiceProvider extends ServiceProvider
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
        URL::forceScheme('https');
        $this->app['request']->server->set('HTTPS', 'on');

        Blade::directive('markdown', function ($expression) {

            $markdown = view(
                str_replace('\'', '', $expression)
            )->render();

            $Parsedown = new \Parsedown();
            return $Parsedown->text($markdown);
        });
    }
}
