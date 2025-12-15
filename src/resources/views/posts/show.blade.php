@extends('layouts.app')

@section('title', $post->title . ' - My Blog')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Content -->
    <div class="lg:col-span-2">
        <!-- Featured Image -->
        @if($post->featured_image)
        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-96 object-cover rounded-lg mb-6">
        @else
        <div class="w-full h-96 bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center rounded-lg mb-6">
            <i class="fas fa-image text-white text-6xl"></i>
        </div>
        @endif

        <!-- Header -->
        <div class="mb-6">
            <div class="flex gap-2 mb-4">
                <span class="bg-blue-100 text-blue-800 px-4 py-1 rounded-full text-sm font-semibold">
                    {{ $post->category->name }}
                </span>
                <span class="text-gray-500">
                    <i class="fas fa-calendar mr-1"></i>{{ $post->created_at->format('M d, Y') }}
                </span>
                <span class="text-gray-500">
                    <i class="fas fa-eye mr-1"></i>{{ $post->views }} views
                </span>
            </div>
            <h1 class="text-4xl font-bold mb-4">{{ $post->title }}</h1>
        </div>

        <!-- Content -->
        <div class="prose prose-lg max-w-none mb-8 bg-white p-6 rounded-lg">
            {!! nl2br(e($post->content)) !!}
        </div>

        <!-- Edit/Delete Actions (Admin Only) -->
        <div class="flex gap-3 mb-8">
            <a href="{{ route('posts.edit', $post) }}" class="bg-yellow-500 text-white px-6 py-2 rounded hover:bg-yellow-600 transition">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-6 py-2 rounded hover:bg-red-600 transition">
                    <i class="fas fa-trash mr-2"></i>Delete
                </button>
            </form>
        </div>

        <!-- Comments Section -->
        <div class="bg-white rounded-lg p-6">
            <h3 class="text-2xl font-bold mb-4">
                <i class="fas fa-comments text-blue-600 mr-2"></i>
                Comments ({{ $post->comments->count() }})
            </h3>

            @if($post->comments->count() > 0)
            <div class="space-y-4 mb-6">
                @foreach($post->comments as $comment)
                <div class="border-l-4 border-blue-600 pl-4 py-2">
                    <div class="font-bold">{{ $comment->author_name }}</div>
                    <div class="text-sm text-gray-500">{{ $comment->created_at->format('M d, Y H:i') }}</div>
                    <p class="mt-2">{{ $comment->content }}</p>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-gray-500 mb-6">No comments yet. Be the first to comment!</p>
            @endif

            <!-- Comment Form -->
            <form action="#" method="POST" class="border-t pt-6">
                <h4 class="font-bold mb-4">Leave a Comment</h4>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold mb-2">Name</label>
                        <input type="text" name="author_name" class="w-full border rounded px-3 py-2" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-2">Email</label>
                        <input type="email" name="author_email" class="w-full border rounded px-3 py-2" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-2">Comment</label>
                        <textarea name="content" rows="4" class="w-full border rounded px-3 py-2" required></textarea>
                    </div>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                        <i class="fas fa-paper-plane mr-2"></i>Post Comment
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Sidebar -->
    <aside>
        <!-- Author Card -->
        <div class="bg-white rounded-lg shadow p-6 sticky top-24">
            <div class="text-center mb-4">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full mx-auto flex items-center justify-center text-white text-2xl mb-2">
                    <i class="fas fa-user"></i>
                </div>
                <h4 class="font-bold">Admin</h4>
                <p class="text-gray-600 text-sm">Blog Author</p>
            </div>
            <p class="text-gray-700 text-center text-sm mb-4">
                Professional blogger sharing insights on technology and web development.
            </p>
            <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
                Follow
            </button>
        </div>

        <!-- Related Posts -->
        @if($relatedPosts->count() > 0)
        <div class="bg-white rounded-lg shadow p-6 mt-6">
            <h4 class="font-bold mb-4">
                <i class="fas fa-link text-purple-600 mr-2"></i>Related Posts
            </h4>
            <ul class="space-y-3">
                @foreach($relatedPosts as $related)
                <li>
                    <a href="{{ route('posts.show', $related->slug) }}" class="text-blue-600 hover:text-blue-800 text-sm hover:underline block">
                        <i class="fas fa-chevron-right mr-2"></i>{{ Str::limit($related->title, 30) }}
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Share Section -->
        <div class="bg-white rounded-lg shadow p-6 mt-6">
            <h4 class="font-bold mb-4">
                <i class="fas fa-share-alt text-green-600 mr-2"></i>Share
            </h4>
            <div class="flex gap-2">
                <a href="#" class="flex-1 bg-blue-600 text-white py-2 rounded text-center hover:bg-blue-700 transition text-sm">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" class="flex-1 bg-blue-400 text-white py-2 rounded text-center hover:bg-blue-500 transition text-sm">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" class="flex-1 bg-red-600 text-white py-2 rounded text-center hover:bg-red-700 transition text-sm">
                    <i class="fab fa-pinterest"></i>
                </a>
            </div>
        </div>
    </aside>
</div>
@endsection
