<?php

namespace Airdev\Blog\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class WebMedia extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'web_medias';

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

    protected static function booted()
    {
        static::saving(function($media) {
            $media->alt = Str::slug($media->alt);
        });
    }

    public static function get($slug)
    {
        $web_media = WebMedia::where('alt', $slug)->first();

        if ($web_media == null) {
            throw new \Exception('Unknow media '.$slug);
        }


        return $web_media->getFirstMedia('web_media');
    }
}
