# 📝 Blog System Setup Guide

Dự án này bao gồm một **Blog đầy đủ** với 5 trang beautifully designed, built với Laravel 12, MySQL, và Tailwind CSS.

## 🎯 5 Trang Chính

| # | Trang | URL | Chức năng |
|---|-------|-----|---------|
| 1️⃣ | **Homepage** | `/` | Hiển thị featured posts, categories, stats |
| 2️⃣ | **Posts List** | `/posts` | Danh sách tất cả posts với filter theo category |
| 3️⃣ | **Post Detail** | `/posts/{slug}` | Chi tiết post với comments, related posts |
| 4️⃣ | **Create Post** | `/posts/create` | Form tạo post mới (upload hình, markdown) |
| 5️⃣ | **Edit Post** | `/posts/{id}/edit` | Form chỉnh sửa post, xoá post |

---

## 🏗️ Architecture

### Database Schema
```
categories
├── id (PK)
├── name
├── slug
├── description
└── timestamps

posts
├── id (PK)
├── title
├── slug (unique)
├── content
├── excerpt
├── category_id (FK)
├── featured_image
├── views (counter)
├── published (boolean)
└── timestamps

comments
├── id (PK)
├── post_id (FK)
├── author_name
├── author_email
├── content
├── approved (boolean)
└── timestamps
```

### Models & Relationships
```php
Post
├── belongsTo(Category)
├── hasMany(Comment)
└── scopePublished()

Category
└── hasMany(Post)

Comment
└── belongsTo(Post)
```

### Controllers
```
PostController (Resource Controller)
├── index()    - List posts với pagination
├── show()     - Post detail + related posts
├── create()   - Form tạo post
├── store()    - Save post
├── edit()     - Form edit post
├── update()   - Update post
└── destroy()  - Delete post

PageController
└── home()     - Homepage
```

### Routes
```php
GET  /              → PageController@home
GET  /posts         → PostController@index
GET  /posts/create  → PostController@create
POST /posts         → PostController@store
GET  /posts/{slug}  → PostController@show
GET  /posts/{id}/edit   → PostController@edit
PUT  /posts/{id}    → PostController@update
DELETE /posts/{id}  → PostController@destroy
```

---

## 🎨 Frontend Features

### Layout
- **Master Layout** (`layouts/app.blade.php`) - Responsive navbar, footer, message flash
- **Tailwind CSS** - Modern, mobile-first design
- **Font Awesome Icons** - Beautiful icons throughout

### Pages Features

#### 1. Homepage (`pages/home.blade.php`)
- 🌟 Featured posts grid (3 posts)
- 📂 Categories sidebar with post counts
- 📊 Blog statistics card
- 🎯 Call-to-action button

#### 2. Posts List (`posts/index.blade.php`)
- 📋 Grid layout (responsive: 1 col mobile → 3 cols desktop)
- 🏷️ Category filter buttons
- 📸 Featured image thumbnails
- ⏱️ Created date & view counter
- 📄 Auto-pagination (6 posts/page)

#### 3. Post Detail (`posts/show.blade.php`)
- 🎨 Large featured image
- 👤 Author card (sidebar)
- 💬 Comments section with form
- 🔗 Related posts (same category)
- 📤 Social share buttons
- ✏️ Edit/Delete admin buttons

#### 4. Create Post (`posts/create.blade.php`)
- 📝 Text inputs (title, excerpt)
- 📂 Category dropdown
- 🖼️ Image upload (drag & drop)
- 💻 Large textarea for content
- ❌ Error validation display
- ✅ Submit/Cancel buttons

#### 5. Edit Post (`posts/edit.blade.php`)
- 📝 Pre-filled form fields
- 🖼️ Current image preview
- 🔄 Option to remove/update image
- 📂 Category selection
- 💾 Update/Cancel buttons

---

## 🚀 Quick Start

### 1. Clone & Navigate
```bash
git clone git@github.com:04ngohaitrieu-ux/laravel-docker-app.git
cd laravel-docker-app
```

### 2. Start Docker
```bash
docker-compose up -d
```

### 3. Install & Seed
```bash
docker-compose exec app composer install
docker-compose exec app php artisan migrate:fresh --seed
```

### 4. Open Browser
```
http://localhost:8080
```

---

## 📊 Sample Data

### Auto-Seeded Categories
- ✅ Technology
- ✅ Programming
- ✅ Web Development
- ✅ Design

### Auto-Seeded Posts
- ✅ 10 sample posts with fake content
- ✅ Random views counter (0-500)
- ✅ Random assigned categories
- ✅ Generated slug from title

### Admin User
```
Email: admin@blog.test
Password: password
```

---

## 🔧 API Endpoints (for AJAX/Mobile Apps)

All endpoints can return JSON by appending `?json=1` or using `Accept: application/json` header:

```bash
# List posts
GET /posts

# Get post detail
GET /posts/{slug}

# Create post
POST /posts
Content-Type: application/json
{
  "title": "My Post",
  "content": "...",
  "category_id": 1
}

# Update post
PUT /posts/{id}

# Delete post
DELETE /posts/{id}
```

---

## 🎯 Features & Improvements

### ✅ Completed
- [x] 3 Models (Post, Category, Comment)
- [x] 2 Controllers (PostController, PageController)
- [x] 3 Migrations (categories, posts, comments)
- [x] 5 Blade views (homepage, list, detail, create, edit)
- [x] 1 Factory (PostFactory for seeding)
- [x] 1 Seeder (DatabaseSeeder with sample data)
- [x] Beautiful Tailwind CSS design
- [x] Image upload support
- [x] Slug generation
- [x] View counter
- [x] Comment system
- [x] Related posts
- [x] Responsive design

### 🔮 Future Enhancements
- [ ] Comment approval system
- [ ] Tags system
- [ ] Search functionality
- [ ] Author profiles
- [ ] Post likes/rating
- [ ] Newsletter subscription
- [ ] Social login
- [ ] Rich text editor (TinyMCE, Quill)
- [ ] SEO optimization
- [ ] Caching
- [ ] API endpoints
- [ ] Admin dashboard
- [ ] User roles & permissions
- [ ] Email notifications

---

## 📁 File Structure

```
src/
├── app/
│   ├── Http/Controllers/
│   │   ├── PostController.php       (95 lines)
│   │   └── PageController.php       (15 lines)
│   └── Models/
│       ├── Post.php                 (27 lines)
│       ├── Category.php             (13 lines)
│       └── Comment.php              (13 lines)
├── database/
│   ├── migrations/
│   │   ├── create_categories_table.php
│   │   ├── create_posts_table.php
│   │   └── create_comments_table.php
│   ├── factories/
│   │   └── PostFactory.php
│   └── seeders/
│       └── DatabaseSeeder.php
├── resources/views/
│   ├── layouts/
│   │   └── app.blade.php            (Master layout)
│   ├── pages/
│   │   └── home.blade.php           (Homepage - 60 lines)
│   └── posts/
│       ├── index.blade.php          (Posts list - 65 lines)
│       ├── show.blade.php           (Post detail - 130 lines)
│       ├── create.blade.php         (Create form - 95 lines)
│       └── edit.blade.php           (Edit form - 110 lines)
└── routes/
    └── web.php                      (14 lines - blog routes)
```

---

## 🧪 Testing

### Seed Database
```bash
docker-compose exec app php artisan db:seed
```

### Create Post via Artisan
```bash
docker-compose exec app php artisan tinker
>>> Post::create(['title' => 'Test', 'slug' => 'test', 'content' => 'Test content', 'category_id' => 1])
```

### List Posts
```bash
docker-compose exec app php artisan tinker
>>> Post::with('category')->get()
```

---

## 🐛 Troubleshooting

### "Post not found"
- Make sure slug exists in database
- Check slug is generated correctly from title

### "Image not showing"
- Make sure image path is correct
- Check `storage/` folder permissions
- Run: `docker-compose exec app php artisan storage:link`

### "Comments not saving"
- Check database has comments table
- Run: `docker-compose exec app php artisan migrate`

---

## 📚 Technologies Used

| Layer | Tech |
|-------|------|
| **Frontend** | Blade Templates, Tailwind CSS, Font Awesome |
| **Backend** | Laravel 12, PHP 8.2 |
| **Database** | MySQL 8.0 |
| **Server** | Nginx 1.28, PHP-FPM |
| **Container** | Docker & Docker Compose |
| **VCS** | Git & GitHub |

---

## 📄 License

MIT License - Feel free to use for learning!

---

## 🎓 Learning Resources

- [Laravel Docs](https://laravel.com/docs)
- [Blade Templating](https://laravel.com/docs/blade)
- [Eloquent ORM](https://laravel.com/docs/eloquent)
- [Tailwind CSS](https://tailwindcss.com/docs)
- [MySQL](https://dev.mysql.com/doc/)

---

**Enjoy your blog! 🚀**
