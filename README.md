# Laravel Docker Application

Ứng dụng Laravel được đóng gói hoàn chỉnh với Docker, Nginx, PHP-FPM và MySQL.

## 📋 Yêu cầu

- Docker Desktop
- Docker Compose
- Git

## 🚀 Cách khởi chạy

### 1. Clone repository
```bash
git clone <repository-url>
cd project-laravel
```

### 2. Khởi động containers
```bash
docker-compose up -d
```

### 3. Cài đặt dependencies
```bash
docker-compose exec -T app composer install
```

### 4. Tạo APP_KEY
```bash
docker-compose exec -T app php artisan key:generate
```

### 5. Chạy database migrations
```bash
docker-compose exec -T app php artisan migrate --force
```

### 6. Truy cập ứng dụng
Mở trình duyệt và truy cập: **http://localhost:8080**

## 📁 Cấu trúc dự án

```
project-laravel/
├── docker-compose.yml      # Cấu hình Docker Compose
├── Dockerfile              # Cấu hình PHP-FPM
├── nginx/
│   └── nginx.conf          # Cấu hình Nginx
├── src/                    # Source code Laravel
│   ├── app/                # Application code
│   ├── bootstrap/          # Bootstrap files
│   ├── config/             # Configuration files
│   ├── database/           # Database migrations & seeders
│   ├── public/             # Public assets (entry point)
│   ├── resources/          # Views & assets
│   ├── routes/             # Application routes
│   ├── storage/            # Logs & cache
│   ├── tests/              # Test files
│   ├── .env                # Environment variables
│   └── composer.json       # PHP dependencies
└── .gitignore             # Git ignore rules
```

## 🐳 Các containers

| Container | Image | Port | Mô tả |
|-----------|-------|------|-------|
| web-server | nginx:stable-alpine | 8080:80 | Web Server |
| laravel-app | php:8.2-fpm-alpine | - | PHP-FPM Application |
| mysql-db | mysql:8.0 | - | MySQL Database |

## 📝 Cấu hình môi trường

File `.env` được tự động tạo từ `.env.example` khi Composer chạy:

```env
APP_NAME=Laravel
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=user
DB_PASSWORD=secret

SESSION_DRIVER=database
```

## 🛠️ Các lệnh hữu ích

### Chạy lệnh Artisan
```bash
docker-compose exec -T app php artisan <command>
```

### Xem logs
```bash
docker-compose logs -f app
docker-compose logs -f web
```

### Dừng containers
```bash
docker-compose down
```

### Xóa tất cả dữ liệu (bao gồm database)
```bash
docker-compose down -v
```

### Rebuild containers
```bash
docker-compose build --no-cache
docker-compose up -d
```

## 💾 Volumes

- **vendor_volume**: Lưu trữ PHP dependencies
- **dbdata**: Lưu trữ MySQL database

## 🔧 Troubleshooting

### Lỗi: "vendor/autoload.php not found"
Chạy: `docker-compose exec -T app composer install`

### Lỗi: "MissingAppKeyException"
Chạy: `docker-compose exec -T app php artisan key:generate`

### Lỗi: Database connection
Đảm bảo MySQL container đang chạy: `docker-compose ps`

## 📄 Licenses

Dự án này sử dụng Laravel Framework - MIT License

---

**Created**: December 15, 2025
