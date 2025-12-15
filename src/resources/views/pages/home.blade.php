@extends('layouts.app')

@section('title', 'Home - My Blog')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Featured Posts -->
    <div class="lg:col-span-2">
        <h2 class="text-3xl font-bold mb-6">
            <i class="fas fa-star text-yellow-500 mr-2"></i>
            Featured Posts
        </h2>
        <div class="grid gap-6">
            @forelse($featuredPosts as $post)
            <article class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden flex flex-col sm:flex-row">
                @if($post->featured_image)
                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full sm:w-48 h-48 object-cover">
                @else
                <div class="w-full sm:w-48 h-48 bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center">
                    <i class="fas fa-image text-white text-3xl"></i>
                </div>
                @endif
                <div class="p-6 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex gap-2 mb-2">
                            <span class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full">
                                {{ $post->category->name }}
                            </span>
                            <span class="text-gray-500 text-sm">
                                <i class="fas fa-eye mr-1"></i>{{ $post->views }} views
                            </span>
                        </div>
                        <h3 class="text-xl font-bold mb-2">{{ $post->title }}</h3>
                        <p class="text-gray-600">{{ Str::limit($post->excerpt ?? $post->content, 100) }}</p>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('posts.show', $post->slug) }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                            Read More <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </article>
            @empty
            <div class="bg-yellow-50 border border-yellow-200 p-6 rounded text-center">
                <i class="fas fa-inbox text-3xl text-yellow-600 mb-2"></i>
                <p class="text-gray-600">No featured posts yet.</p>
            </div>
            @endforelse
        </div>
        <div class="mt-8 text-center">
            <a href="/posts" class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition inline-block">
                <i class="fas fa-list mr-2"></i>View All Posts
            </a>
        </div>
    </div>

    <!-- Sidebar - Categories -->
    <aside>
        <div class="bg-white rounded-lg shadow p-6 sticky top-24">
            <h3 class="text-xl font-bold mb-4">
                <i class="fas fa-folder text-purple-600 mr-2"></i>Categories
            </h3>
            <ul class="space-y-3">
                @forelse($categories as $category)
                <li>
                    <a href="/posts?category={{ $category->id }}" class="text-blue-600 hover:text-blue-800 block p-2 rounded hover:bg-blue-50 transition">
                        <i class="fas fa-folder-open mr-2"></i>{{ $category->name }}
                        <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded ml-2">{{ $category->posts_count }}</span>
                    </a>
                </li>
                @empty
                <li class="text-gray-500 text-sm">No categories yet</li>
                @endforelse
            </ul>
        </div>

        <!-- Stats Card -->
        <div class="bg-white rounded-lg shadow p-6 mt-6">
            <h3 class="text-xl font-bold mb-4">
                <i class="fas fa-chart-bar text-green-600 mr-2"></i>Blog Stats
            </h3>
            <div class="space-y-2 text-sm">
                <p><strong>Total Posts:</strong> <span class="text-blue-600">{{ \App\Models\Post::count() }}</span></p>
                <p><strong>Total Views:</strong> <span class="text-blue-600">{{ \App\Models\Post::sum('views') }}</span></p>
                <p><strong>Categories:</strong> <span class="text-blue-600">{{ \App\Models\Category::count() }}</span></p>
            </div>
        </div>
    </aside>
</div>
@endsection
