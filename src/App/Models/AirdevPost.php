<?php

namespace Airdev\Blog\App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Str;

class AirdevPost extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'airdev_posts';

    protected $dates = ['publish_date'];

    public function registerMediaConversions(Media $media = null): void
    {
        $format = explode('/', $media->getAttribute('mime_type'))[1];
        if ($format === 'jpeg')
            $format = 'jpg';

        $this->addMediaConversion('responsive')
            ->format($format)
            ->withResponsiveImages();

        // If image is .png, we don't convert to webp
        if (!$media->getAttribute('mime_type') != 'png') {
            $this->addMediaConversion('responsive_webp')
                ->format('webp')
                ->withResponsiveImages();
        }

        $this->addMediaConversion('og')
            ->width(1200);

        $this->addMediaConversion('nova-thumb')
            ->width(150);
    }

    public function getIntroAttribute()
    {
        return Str::limit(strip_tags($this->title_intro), config('blog.blog_intro_limit', 200));
    }

    public function getIsPublishableAttribute()
    {
        return $this->is_active && $this->publish_date && $this->publish_date <= Carbon::today();
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
