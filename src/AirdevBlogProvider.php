<?php

namespace Airdev\Blog;


use Airdev\Blog\App\Nova\AirdevPostResource;
use Airdev\Blog\App\Nova\UserResource;
use Airdev\Blog\App\Views\Components\Post;
use Airdev\Blog\App\Views\Components\Posts;
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
        $this->publishes([
            __DIR__ . '/Database/Migrations/' => database_path('migrations')
        ], 'airdev-blog-migrations');

        $this->publishes([
            __DIR__.'/config/blog.php' => config_path('blog.php'),
        ], 'airdev-blog-config');

        Nova::resources([
            AirdevPostResource::class,
            config('blog.user-nova-resource', UserResource::class),
        ]);
    }
}
