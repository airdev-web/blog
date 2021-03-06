<?php

namespace Airdev\Blog\App\Nova;

use Airdev\Blog\App\Models\AirdevPost;
use Carbon\Carbon;
use Ebess\AdvancedNovaMediaLibrary\Fields\Files;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Eminiarts\Tabs\Tabs;
use Eminiarts\Tabs\TabsOnEdit;
use Illuminate\Http\Request;
use Khalin\Nova\Field\Link;
use Kraftbit\NovaTinymce5Editor\NovaTinymce5Editor;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource;

class AirdevPostResource extends Resource
{
    use TabsOnEdit;

    public static $model = AirdevPost::class;

    public static $title = 'id';

    public static $indexDefaultOrder = [
        'publish_date' => 'desc'
    ];

    public static $search = [
        ''
    ];

    public static function label()
    {
        return 'Articles';
    }

    public function fields(Request $request)
    {
        return [
            Tabs::make('Tabs', [
                'Informations sur l\'article' => [
                    ID::make()->sortable(),

                    Link::make('PrĂ©visualisation', 'id')
                        ->url(function() {
                            return config('blog.blog-preview-route', '/blog') . '/' . $this->slug . '?preview=true';
                        })
                        ->text('PrĂ©visualiser')
                        ->icon()
                        ->blank()
                        ->hideWhenUpdating()
                        ->hideWhenCreating(),

                    Images::make('Image', 'post_image')
                        ->conversionOnIndexView('nova-thumb')
                        ->conversionOnDetailView('nova-thumb'),

                    Text::make('Titre', 'title')
                        ->rules('required'),

                    Slug::make('Slug', 'slug')
                        ->rules('required')
                        ->hideFromIndex(),

                    Gravatar::make('', 'author.email')->maxWidth(50),

                    BelongsTo::make('Auteur', 'author', config('blog.nova-user-resource', UserResource::class))
                        ->rules('required'),

                    Text::make('Nom du bouton d\'introduction', 'link_intro_title')
                        ->hideFromIndex(),
                    Text::make('Lien du bouton d\'introduction', 'link_intro_href')
                        ->hideFromIndex(),

                    Text::make('Nom banniĂ¨re contact', 'banner_title')
                        ->hideFromIndex(),
                    Text::make('Titre du bouton contact', 'banner_link')
                        ->hideFromIndex(),
                ],

                'VisibilitĂ© en ligne' => [
                    Boolean::make('PubliĂ©', function() {
                        return $this->publish_date && $this->publish_date <= Carbon::today();
                    }),
                    Boolean::make('ActivĂ©', 'is_active'),
                    Boolean::make('Index Google', 'is_google_index'),
                    Boolean::make('Meta complĂ¨tes', function() {
                        return !(empty($this->meta_title) || empty($this->meta_description));
                    }),

                    Date::make('Date de publication', 'publish_date')
                        ->format('DD/MM/YYYY'),
                ],

                'Contenu de l\'article' => [
                    NovaTinymce5Editor::make('Introduction', 'title_intro')
                        ->nullable()
                        ->hideFromIndex(),

                    NovaTinymce5Editor::make('Contenu', 'content')
                        ->nullable()
                        ->hideFromIndex(),
                ],

                'Meta donnĂ©es' => [
                    Text::make('meta_title')
                        ->hideFromIndex(),
                    Text::make('meta_description')
                        ->hideFromIndex(),
                ],

                'Timestamps' => [
                    DateTime::make('ModifiĂ© le', 'updated_at')
                        ->format('DD/MM/YYYY HH:mm'),
                ]
            ])
                ->withToolbar(),
        ];
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        if (empty($request->get('orderBy'))) {
            $query->getQuery()->orders = [];
            return $query->orderBy(key(static::$indexDefaultOrder), reset(static::$indexDefaultOrder));
        }
        return $query;
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
