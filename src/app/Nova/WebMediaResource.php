<?php

namespace Airdev\Blog\App\Nova;

use Airdev\Blog\App\Models\WebMedia;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Http\Request;
use Khalin\Nova\Field\Link;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Resource;

class WebMediaResource extends Resource
{
    public static $model = WebMedia::class;

    public static $title = 'id';

    public static $search = [
        ''
    ];

    public static $with = ['media'];

    public static function label()
    {
        return 'Medias';
    }

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Slug::make('Titre', 'alt')
                ->rules('required'),

            Images::make('Image', 'web_media')
                ->conversionOnIndexView('nova-thumb')
                ->conversionOnDetailView('nova-thumb'),

            Link::make('Prévisualisation', 'id')
                ->url(function() {
                    return $this->getFirstMedia('web_media') ? $this->getFirstMedia('web_media')->getUrl('webp') : '#';
                })
                ->text('Prévisualiser')
                ->icon()
                ->blank()
                ->hideWhenUpdating()
                ->hideWhenCreating(),
        ];
    }

    public function cards(Request $request)
    {
        return [];
    }

    public function filters(Request $request)
    {
        return [];
    }

    public function lenses(Request $request)
    {
        return [];
    }

    public function actions(Request $request)
    {
        return [];
    }
}
