@extends('layouts.app')

@section('title', 'Create New Post - My Blog')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="text-4xl font-bold">
            <i class="fas fa-pen-to-square text-blue-600 mr-2"></i>Create New Post
        </h1>
        <p class="text-gray-600 mt-2">Share your ideas with the world</p>
    </div>

    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow p-8">
        @csrf

        @if($errors->any())
        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <h4 class="font-bold mb-2">Please fix the following errors:</h4>
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Title -->
        <div class="mb-6">
            <label class="block text-sm font-semibold mb-2">
                <i class="fas fa-heading mr-2 text-blue-600"></i>Post Title
            </label>
            <input type="text" name="title" value="{{ old('title') }}" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600" placeholder="Enter post title" required>
            @error('title')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Category -->
        <div class="mb-6">
            <label class="block text-sm font-semibold mb-2">
                <i class="fas fa-folder mr-2 text-blue-600"></i>Category
            </label>
            <select name="category_id" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600" required>
                <option value="">Select a category</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
            @error('category_id')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Featured Image -->
        <div class="mb-6">
            <label class="block text-sm font-semibold mb-2">
                <i class="fas fa-image mr-2 text-blue-600"></i>Featured Image (Optional)
            </label>
            <div class="border-2 border-dashed rounded-lg p-6 text-center cursor-pointer hover:bg-gray-50 transition">
                <input type="file" name="featured_image" class="hidden" id="image" accept="image/*">
                <label for="image" class="cursor-pointer">
                    <i class="fas fa-cloud-arrow-up text-3xl text-blue-600 mb-2"></i>
                    <p class="font-semibold">Click to upload image</p>
                    <p class="text-gray-600 text-sm">PNG, JPG, GIF up to 2MB</p>
                </label>
            </div>
            @error('featured_image')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Excerpt -->
        <div class="mb-6">
            <label class="block text-sm font-semibold mb-2">
                <i class="fas fa-quote-left mr-2 text-blue-600"></i>Excerpt (Optional)
            </label>
            <textarea name="excerpt" rows="2" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600" placeholder="Short summary of your post">{{ old('excerpt') }}</textarea>
            @error('excerpt')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Content -->
        <div class="mb-6">
            <label class="block text-sm font-semibold mb-2">
                <i class="fas fa-file-lines mr-2 text-blue-600"></i>Content
            </label>
            <textarea name="content" rows="10" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600 font-mono" placeholder="Write your post content here..." required>{{ old('content') }}</textarea>
            <p class="text-gray-600 text-sm mt-2">Markdown supported</p>
            @error('content')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Buttons -->
        <div class="flex gap-4">
            <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition font-semibold flex-1">
                <i class="fas fa-check mr-2"></i>Publish Post
            </button>
            <a href="/posts" class="bg-gray-300 text-gray-800 px-8 py-3 rounded-lg hover:bg-gray-400 transition font-semibold flex-1 text-center">
                <i class="fas fa-ban mr-2"></i>Cancel
            </a>
        </div>
    </form>
</div>
@endsection
