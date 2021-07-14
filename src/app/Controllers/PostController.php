<?php

namespace Airdev\Blog\App\Controllers;

use Airdev\Blog\App\Models\Post;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::where('is_active', true)
            ->whereDate('publish_date', '<=', Carbon::today())
            ->orderBy('created_at', 'desc')
            ->with('author')
            ->get();

        return view('pages.blog.index', ['posts' => $posts]);
    }

    public function post(Request $request, $slug) {
        $post = Post::where('slug', $slug)
            ->with('author')
            ->first();

        if ($request->preview && Auth::check())
            return view('pages.blog.post', ['post' => $post]);

        // Post doesn't exists
        if ($post == null)
            return redirect(route('blog'), 301);

        // Post exists but isn't active
        if (!$post->is_active || !$post->publish_date || $post->publish_date > Carbon::today())
            return redirect(route('blog'), 302);

        return view('pages.blog.post', ['post' => $post]);
    }
}
