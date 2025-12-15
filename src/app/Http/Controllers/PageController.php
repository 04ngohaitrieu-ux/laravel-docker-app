<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;

class PageController extends Controller
{
    // Homepage
    public function home()
    {
        $featuredPosts = Post::published()->latest()->limit(3)->get();
        $categories = Category::withCount('posts')->limit(5)->get();
        return view('pages.home', compact('featuredPosts', 'categories'));
    }
}
