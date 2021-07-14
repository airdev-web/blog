<?php

namespace Airdev\Blog;


use Airdev\Blog\App\Nova\PostResource;
use Airdev\Blog\App\Nova\UserResource;
use Airdev\Blog\App\Nova\WebMediaResource;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Nova;

class AirdevBlogProvider extends ServiceProvider
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
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        Nova::resources([
            WebMediaResource::class,
            PostResource::class,
            config('blog.user-nova-resource', UserResource::class),
        ]);
    }
}
