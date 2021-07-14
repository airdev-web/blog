<?php

namespace Airdev\Blog\App\Models;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements HasMedia
{
    use HasFactory, Notifiable, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getIsGuestAttribute()
    {
        return $this->role === 'guest';
    }

    public function medias($collection)
    {
        $get_medias = $collection == 'undefined' ? $this->getMedia() : $this->getMedia($collection);

        $medias = [];
        foreach ($get_medias as $media) {
            array_push($medias, [
                'id' => $media->id,
                'url' => $media->getFullUrl(),
            ]);
        }

        return $medias;
    }
}
