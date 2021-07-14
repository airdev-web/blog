<?php

namespace Airdev\Blog\App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Post extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $dates = ['publish_date'];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('webp')
            ->format('webp')
            ->withResponsiveImages();

        $this->addMediaConversion('og')
            ->width(1200);

        $this->addMediaConversion('nova-thumb')
            ->width(150);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
