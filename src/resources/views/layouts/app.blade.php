<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Blog - Laravel')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-blue-600">
                <i class="fas fa-blog mr-2"></i>
                <a href="/">My Blog</a>
            </h1>
            <ul class="flex gap-6">
                <li><a href="/" class="hover:text-blue-600 transition">Home</a></li>
                <li><a href="/posts" class="hover:text-blue-600 transition">Posts</a></li>
                <li><a href="/posts/create" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    <i class="fas fa-pen-to-square mr-1"></i>New Post</a></li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-4 py-8">
        @if($message = Session::get('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded flex justify-between items-center">
                <span>{{ $message }}</span>
                <button onclick="this.parentElement.style.display='none';" class="text-xl">&times;</button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white mt-12 py-6">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <p>&copy; 2025 My Blog. All rights reserved.</p>
            <p class="text-gray-400">Built with Laravel & Tailwind CSS</p>
        </div>
    </footer>
</body>
</html>
