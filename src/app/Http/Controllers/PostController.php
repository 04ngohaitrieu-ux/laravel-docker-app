<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // Homepage - list tất cả posts
    public function index()
    {
        $posts = Post::published()->with('category')->latest()->paginate(6);
        $categories = Category::withCount('posts')->get();
        return view('posts.index', compact('posts', 'categories'));
    }

    // Detail 1 post
    public function show($slug)
    {
        $post = Post::where('slug', $slug)->with(['category', 'comments'])->firstOrFail();
        $post->increment('views');
        $relatedPosts = Post::where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->published()
            ->latest()
            ->limit(3)
            ->get();
        return view('posts.show', compact('post', 'relatedPosts'));
    }

    // Form tạo post
    public function create()
    {
        $categories = Category::all();
        return view('posts.create', compact('categories'));
    }

    // Lưu post mới
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'category_id' => 'required|exists:categories,id',
            'featured_image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('posts', 'public');
            $validated['featured_image'] = $path;
        }

        $validated['slug'] = str()->slug($validated['title']);
        Post::create($validated);

        return redirect('/posts')->with('success', 'Post tạo thành công!');
    }

    // Form edit post
    public function edit(Post $post)
    {
        $categories = Category::all();
        return view('posts.edit', compact('post', 'categories'));
    }

    // Update post
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'category_id' => 'required|exists:categories,id',
            'featured_image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('posts', 'public');
            $validated['featured_image'] = $path;
        }

        $validated['slug'] = str()->slug($validated['title']);
        $post->update($validated);

        return redirect("/posts/{$post->slug}")->with('success', 'Post cập nhật thành công!');
    }

    // Xoá post
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect('/posts')->with('success', 'Post xoá thành công!');
    }
}
