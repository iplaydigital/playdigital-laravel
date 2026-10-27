<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        $posts = Post::orderByDesc('published_at')->get();

        return view('pages.blog.index', [
            'posts' => $posts,
        ]);
    }

    public function show(Post $post): View
    {
        $recentPosts = Post::where('id', '!=', $post->id)
            ->orderByDesc('published_at')
            ->limit(2)
            ->get();

        return view('pages.blog.show', [
            'post' => $post,
            'recentPosts' => $recentPosts,
        ]);
    }
}
