@extends('layouts.app')

@section('title', 'All Posts - My Blog')

@section('content')
<div class="mb-6">
    <h1 class="text-4xl font-bold mb-2">
        <i class="fas fa-newspaper text-blue-600 mr-2"></i>Blog Posts
    </h1>
    <p class="text-gray-600">Discover amazing articles and stories</p>
</div>

<!-- Filter by Category -->
<div class="mb-6 flex gap-2 flex-wrap">
    <a href="/posts" class="px-4 py-2 rounded {{ !request('category') ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800' }} hover:bg-blue-600 hover:text-white transition">
        All Posts
    </a>
    @foreach($categories as $category)
    <a href="/posts?category={{ $category->id }}" class="px-4 py-2 rounded {{ request('category') == $category->id ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800' }} hover:bg-blue-600 hover:text-white transition">
        {{ $category->name }}
    </a>
    @endforeach
</div>

<!-- Posts Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($posts as $post)
    <article class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden flex flex-col">
        <!-- Featured Image -->
        @if($post->featured_image)
        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
        @else
        <div class="w-full h-48 bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center">
            <i class="fas fa-image text-white text-4xl"></i>
        </div>
        @endif

        <!-- Content -->
        <div class="p-5 flex-1 flex flex-col">
            <!-- Category Badge -->
            <div class="mb-3">
                <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full">
                    {{ $post->category->name }}
                </span>
            </div>

            <!-- Title -->
            <h2 class="text-lg font-bold mb-2 line-clamp-2">{{ $post->title }}</h2>

            <!-- Excerpt -->
            <p class="text-gray-600 text-sm mb-4 line-clamp-2 flex-1">
                {{ Str::limit($post->excerpt ?? $post->content, 80) }}
            </p>

            <!-- Meta Info -->
            <div class="flex justify-between items-center text-gray-500 text-xs mb-4">
                <span><i class="fas fa-calendar mr-1"></i>{{ $post->created_at->format('M d, Y') }}</span>
                <span><i class="fas fa-eye mr-1"></i>{{ $post->views }}</span>
            </div>

            <!-- Read More Button -->
            <a href="{{ route('posts.show', $post->slug) }}" class="bg-blue-600 text-white text-center py-2 rounded hover:bg-blue-700 transition font-semibold">
                Read Article
            </a>
        </div>
    </article>
    @empty
    <div class="col-span-full bg-yellow-50 border border-yellow-200 p-12 rounded text-center">
        <i class="fas fa-inbox text-5xl text-yellow-600 mb-4"></i>
        <h3 class="text-xl font-bold mb-2">No Posts Found</h3>
        <p class="text-gray-600">No posts available yet. <a href="/posts/create" class="text-blue-600 hover:underline">Create one now!</a></p>
    </div>
    @endforelse
</div>

<!-- Pagination -->
<div class="mt-8">
    {{ $posts->links() }}
</div>
@endsection
