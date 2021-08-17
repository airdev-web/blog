<?php

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
