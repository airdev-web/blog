# Airdev/blog
A package that quickly provide blog system.

It's only working with Airdev web base project.

## Installation
```shell
composer require airdev/blog
```

Next, add it to the Laravel's package providers in ``config/app.php``
```php
/*
 * Package Service Providers...
 */
Airdev\Blog\AirdevBlogProvider::class,
```

Publish migrations, configure it if needed, the migrate.
```shell
php artisan vendor:publish --tag=airdev-blog-migrations
php artisan migrate
```

Publish the TiniMCE config file :
```shell
php artisan vendor:publish --provider="Kraftbit\NovaTinymce5Editor\FieldServiceProvider"
```
Add your TinyMCE cloud API key here or to your .env file like this :
```env
TINYMCE_API_KEY=your-key-here
```
Then, publish airdev/blog config file :
```shell
php artisan vendor:publish --tag=airdev-blog-config
```



You can now edit some configuration.
```php
return [
    'user-nova-resource' => \App\Nova\User::class,
    'user-model' => \App\Models\User::class,
    
    // Preview url for posts
    // for exemple : example.com/blog/your-post-slug
    'blog-preview-route' => '/blog',

    // Str::limit to shorten the intro text
    // If set to 'null', it will not short it
    'blog_intro_limit' => 200,
];
```

## Usage
You can now access to blog ressources on Nova's Interface.

You can now create routes that will fetch the posts. Do not forget to create views.
```php
Route::get('/blog', function() {
    // If no number of posts specified, it will take all posts
    return view('blog', ['posts' => AirdevPostController::get_posts(5)]);
})->name('blog');

Route::get('/blog/{slug}', function($slug) {
    $post = AirdevPostController::get_post_by_slug($slug);

    // Post doesn't exists
    if ($post == null)
        abort(404);

    // Post exists but isn't active
    if (!$post->isPublishable)
        return redirect(route('blog'), 302);

    return view('post', ['post' => $post]);
})->name('blog.post');
```

Example for listing all available posts
```blade
@foreach ($posts as $post)
    <div class="col-4">
        <div class="card">
            <x-airdev-picture :media="$post->getFirstMedia('post_image')" slug="{{ $post->slug }}" class="card-img-top"></x-airdev-picture>
            <div class="card-body">
                <h3 class="card-title">{{ $post->title }}</h3>
                <div class="card-text">{{ $post->intro }}</div>
                <a href="{{ route('blog.post', $post->slug) }}">En savoir plus</a>
            </div>
        </div>
    </div>
@endforeach
```