<?php

namespace Airdev\Blog\App\Controllers;

use Airdev\Blog\App\Models\AirdevPost;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AirdevPostController extends Controller
{
    public function index()
    {
        return view('airdev::blog.index', ['posts' => self::get_posts(4)]);
    }

    public static function get_posts($count = null)
    {
        $posts = AirdevPost::where('is_active', true)
            ->whereDate('publish_date', '<=', Carbon::today())
            ->orderBy('created_at', 'desc')
            ->with('author');

        // If asked, take the required number of posts
        if ($count != null)
            $posts = $posts->take($count);

       return $posts->get();
    }

    public static function get_post_by_slug($slug) {
        $post = AirdevPost::where('slug', $slug)
            ->with('author')
            ->first();

        if (request()->preview && Auth::check())
            return $post;

        return $post;
    }
}
