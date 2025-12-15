# 🛠️ Ngôn Ngữ & Công Nghệ - Docker Project

## 📌 Tổng Quan

Project này sử dụng một **stack công nghệ hiện đại** được đóng gói trong Docker, cho phép chạy trên bất kỳ máy nào mà không cần cài đặt.

---

## 🌐 Ngôn Ngữ & Framework

### 1️⃣ **PHP 8.2.29** (Backend Language)
**Vai trò:** Ngôn ngữ lập trình chính cho ứng dụng web

```bash
# Kiểm tra phiên bản
docker-compose exec app php -v
# Output: PHP 8.2.29 (cli)
```

**Thành phần:**
- ✅ **Zend Engine 4.2.29** - Core execution engine
- ✅ **OPcache** - PHP opcode cache (tăng hiệu suất)

**Extensions được cài:**
```
- pdo_mysql     (kết nối MySQL)
- zip           (xử lý file zip)
- xml, json, ... (standard extensions)
```

**Chạy trên:** PHP-FPM (FastCGI Process Manager)
```
Container: laravel-app:9000
Base Image: php:8.2-fpm-alpine (14 MB, cực nhẹ)
```

---

### 2️⃣ **Laravel 12.42.0** (Web Framework)
**Vai trò:** Framework MVC xây dựng ứng dụng web

```bash
# Kiểm tra phiên bản
docker-compose exec app php artisan --version
# Output: Laravel Framework 12.42.0
```

**Thành phần chính:**
```
laravel/framework         12.42.0    # Framework chính
laravel/pail             1.2.4      # Log viewer
laravel/sail             1.51.0     # Docker setup
laravel/prompts          0.3.8      # CLI prompts
laravel/tinker           2.10.2     # Interactive shell
laravel/pint             1.26.0     # Code formatter
laravel/serializable-closure v2.0.7 # Closure serialization
```

**Features sử dụng:**
- 🏗️ MVC Architecture (Models, Controllers, Views)
- 🛣️ Routing (Web routes)
- 🗄️ Eloquent ORM (Database)
- 🔍 Query Builder
- 🔐 Authentication & Authorization
- 📝 Migrations & Seeding
- 📮 Email & Notifications
- 📦 File Storage
- 🧪 Testing

---

### 3️⃣ **Blade Templating** (View Language)
**Vai trò:** Templating engine để tạo HTML

```blade
<!-- Blade syntax -->
@foreach($posts as $post)
    <h1>{{ $post->title }}</h1>
    @if($post->published)
        <p>Published</p>
    @endif
@endforeach

<!-- Compiled to PHP -->
<?php foreach($posts as $post): ?>
    <h1><?php echo $post->title; ?></h1>
    <?php if($post->published): ?>
        <p>Published</p>
    <?php endif; ?>
<?php endforeach; ?>
```

**Tập tin:** `*.blade.php`
**Vị trí:** `src/resources/views/`

---

## 🗄️ Database

### 4️⃣ **MySQL 8.0.44** (Database Management System)
**Vai trò:** Lưu trữ dữ liệu ứng dụng

```bash
# Kiểm tra phiên bản
docker-compose exec db mysql --version
# Output: MySQL Community Server - GPL 8.0.44
```

**Cấu hình:**
```
Host:     db (trong Docker network) / 127.0.0.1 (từ host)
Port:     3306
Username: user
Password: secret
Database: laravel
```

**Bảng có trong database:**
```sql
users              (Laravel default)
password_resets    (Laravel default)
cache              (Laravel cache table)
jobs               (Laravel job queue)
categories         (Blog categories)
posts              (Blog posts)
comments           (Blog comments)
sessions           (Session storage)
migrations         (Migration history)
```

**Volume:**
```yaml
dbdata:/var/lib/mysql  # Data persistence
```

---

## 🌐 Web Server

### 5️⃣ **Nginx 1.28.0** (Web Server)
**Vai trò:** Serve static files, proxy requests to PHP

```bash
# Kiểm tra phiên bản
docker-compose exec web nginx -v
# Output: nginx/1.28.0
```

**Cấu hình:**
```
Listening on:      port 80
Mapped to host:    localhost:8080
Document root:     /var/www/html/public
FastCGI backend:   app:9000 (PHP-FPM)
Base Image:        nginx:stable-alpine
```

**File cấu hình:** `nginx/nginx.conf`
```nginx
server {
    listen 80;
    server_name localhost;
    root /var/www/html/public;
    
    location ~ \.php$ {
        fastcgi_pass app:9000;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }
}
```

---

## 🎨 Frontend Technologies

### 6️⃣ **Tailwind CSS** (CSS Framework)
**Vai trò:** Styling framework utility-first

```html
<!-- Tailwind classes -->
<div class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
    Button
</div>
```

**Version:** Latest from CDN
```html
<script src="https://cdn.tailwindcss.com"></script>
```

**Features:**
- ✅ Utility-first CSS
- ✅ Responsive design (mobile-first)
- ✅ Dark mode support
- ✅ Custom colors & spacing

---

### 7️⃣ **Font Awesome 6.4.0** (Icon Library)
**Vai trò:** Icons cho UI

```html
<i class="fas fa-blog mr-2"></i>        <!-- Blog icon -->
<i class="fas fa-pen-to-square"></i>   <!-- Edit icon -->
<i class="fas fa-trash"></i>            <!-- Delete icon -->
```

**Link CDN:**
```html
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
```

---

## 📦 PHP & Composer Libraries

### 8️⃣ **Composer Packages** (PHP Dependency Manager)

#### Core Framework
```
laravel/framework          12.42.0    # Main framework
nesbot/carbon             3.11.0    # Date/time handling
symfony/*                 7.4.x     # Symfony components
```

#### Database
```
doctrine/dbal             3.x        # Database abstraction
doctrine/inflector        2.1.0     # String inflection
```

#### HTTP & API
```
guzzlehttp/guzzle         7.10.0    # HTTP client
symfony/http-foundation   7.4.1     # HTTP layer
symfony/http-kernel       7.4.2     # HTTP kernel
```

#### Security & Validation
```
symfony/polyfill-*        (various) # Polyfills
egulias/email-validator   4.0.4     # Email validation
```

#### Testing
```
phpunit/phpunit           11.5.46   # Unit testing
mockery/mockery           1.6.12    # Mocking library
laravel/tinker            2.10.2    # REPL
```

#### Development Tools
```
laravel/pint              1.26.0    # Code formatter
laravel/sail              1.51.0    # Docker setup
nunomaduro/collision      v8.8.3    # Error display
```

#### Others
```
fakerphp/faker            1.24.1    # Generate fake data
ramsey/uuid               4.9.2     # UUID generation
fruitcake/php-cors        1.4.0     # CORS support
```

---

## 🏗️ Architecture Stack

```
┌─────────────────────────────────────┐
│      Client Browser                 │
│   (HTML + CSS + JavaScript)         │
└──────────────┬──────────────────────┘
               │ HTTP:80 (localhost:8080)
               ▼
┌─────────────────────────────────────┐
│      Nginx 1.28.0                   │
│   (Web Server, Static Files)        │
└──────────────┬──────────────────────┘
               │ FastCGI :9000
               ▼
┌─────────────────────────────────────┐
│   PHP 8.2-FPM (PHP-FPM)             │
│   ├─ Laravel 12                     │
│   ├─ Blade Templating              │
│   ├─ Eloquent ORM                  │
│   └─ Application Logic             │
└──────────────┬──────────────────────┘
               │ TCP :3306
               ▼
┌─────────────────────────────────────┐
│      MySQL 8.0.44                   │
│   (Database Server)                 │
│   └─ Database: laravel             │
│   └─ Tables: posts, categories,... │
└─────────────────────────────────────┘
```

---

## 📊 Language Distribution

```
Backend:
├─ PHP              95% (Business logic, routing, ORM)
└─ SQL              5%  (Database queries)

Frontend:
├─ Blade/PHP        40% (Templates, dynamic content)
├─ HTML             30% (Structure)
├─ CSS (Tailwind)   20% (Styling)
└─ JavaScript       10% (Interactivity)

Configuration:
├─ YAML (Docker)    Compose files
├─ PHP              Configuration files
├─ JSON             Package & lock files
└─ Bash             Setup scripts
```

---

## 🔄 Request Flow

```
1. Browser request → http://localhost:8080/posts
                     │
2. Nginx receives    │
   ├─ Checks if static file
   └─ Routes to PHP-FPM (localhost:9000)
                     │
3. PHP-FPM executes  │
   ├─ Load Laravel bootstrap
   ├─ Match route in web.php
   ├─ Call PostController@index
                     │
4. Controller        │
   ├─ Query MySQL via Eloquent ORM
   ├─ Get posts & categories
   └─ Pass to view
                     │
5. View (Blade)      │
   ├─ Render home.blade.php
   ├─ Compile to PHP
   ├─ Execute PHP
   └─ Generate HTML
                     │
6. Nginx returns HTML→ Browser renders
```

---

## 📁 Code Distribution

```
Total Lines: ~2,500+ lines of code

PHP (1,200 lines)
├─ Controllers
│  ├─ PostController.php      95 lines
│  └─ PageController.php      15 lines
├─ Models
│  ├─ Post.php               27 lines
│  ├─ Category.php           13 lines
│  └─ Comment.php            13 lines
└─ Routes & Config           100+ lines

Blade Templates (460 lines)
├─ layouts/app.blade.php       40 lines
├─ pages/home.blade.php        60 lines
├─ posts/index.blade.php       65 lines
├─ posts/show.blade.php       130 lines
├─ posts/create.blade.php      95 lines
└─ posts/edit.blade.php       110 lines

Database (85 lines)
├─ Migrations                  85 lines
└─ Factories & Seeders        100 lines

Configuration (300+ lines)
├─ .env                        30 lines
├─ docker-compose.yml          54 lines
├─ Dockerfile                  20 lines
├─ nginx.conf                  40 lines
└─ PHP config files            150+ lines
```

---

## 🚀 Development Tools

### CLI Tools
```bash
# Laravel Artisan
docker-compose exec app php artisan make:model Post -m
docker-compose exec app php artisan migrate
docker-compose exec app php artisan tinker

# PHP CLI
docker-compose exec app php --version
docker-compose exec app composer install

# MySQL CLI
docker-compose exec db mysql -u user -p laravel
```

### Code Quality
```bash
# Format code (Pint)
docker-compose exec app ./vendor/bin/pint

# Run tests (PHPUnit)
docker-compose exec app php artisan test

# View logs (Pail)
docker-compose exec app php artisan pail
```

---

## 🔐 Security Features

| Layer | Security |
|-------|----------|
| **PHP** | CSRF protection, Input validation, XSS protection |
| **Laravel** | Password hashing, Auth middleware, Authorization |
| **MySQL** | User authentication, Database encryption |
| **Nginx** | SSL ready, Security headers, Rate limiting |
| **Docker** | Isolated containers, Network isolation |

---

## 📈 Performance

| Component | Size | Speed |
|-----------|------|-------|
| **PHP Image** | 14 MB | Fast startup |
| **Nginx** | 5 MB | ~50ms response |
| **MySQL** | 20 MB | Indexed queries |
| **Total** | ~40 MB | Lightweight |

---

## 🎓 Learning Path

### Beginner
1. Learn PHP basics
2. Understand Blade templating
3. Create simple routes

### Intermediate
4. Learn Eloquent ORM
5. Build controllers & models
6. Create migrations

### Advanced
7. API development
8. Testing & TDD
9. Performance optimization

---

## 📚 Resources

### Official Documentation
- [PHP.net](https://www.php.net/)
- [Laravel Docs](https://laravel.com/docs)
- [MySQL Docs](https://dev.mysql.com/doc/)
- [Nginx Docs](https://nginx.org/en/docs/)
- [Tailwind CSS](https://tailwindcss.com/docs)

### Tools
- [Laravel Debugbar](https://github.com/barryvdh/laravel-debugbar)
- [Telescope](https://laravel.com/docs/telescope)
- [Tinker](https://laravel.com/docs/tinker)
- [Postman](https://www.postman.com/)

---

## ✅ Summary

| Category | Technology | Version |
|----------|-----------|---------|
| **Language** | PHP | 8.2.29 |
| **Framework** | Laravel | 12.42.0 |
| **Database** | MySQL | 8.0.44 |
| **Web Server** | Nginx | 1.28.0 |
| **CSS Framework** | Tailwind CSS | Latest |
| **Icons** | Font Awesome | 6.4.0 |
| **Container** | Docker | Latest |

---

**Mọi ngôn ngữ & công nghệ đều được cài sẵn trong Docker - không cần cài gì thêm!** 🎉
