# Hướng dẫn cài đặt chi tiết

## Bước 1: Chuẩn bị môi trường

### Yêu cầu hệ thống
- **Windows 10/11** với WSL2 hoặc Docker Desktop cho Windows
- **Docker Desktop** phiên bản mới nhất
- **Git** để clone repository
- **PowerShell** hoặc Command Prompt

### Cài đặt Docker Desktop
1. Tải từ: https://www.docker.com/products/docker-desktop
2. Cài đặt và khởi động Docker Desktop
3. Chờ cho đến khi Docker khởi động hoàn toàn

## Bước 2: Clone và khởi chạy dự án

```powershell
# 1. Clone repository
git clone <your-github-repo-url>
cd project-laravel

# 2. Khởi động tất cả containers
docker-compose up -d

# 3. Kiểm tra containers
docker-compose ps
```

Bạn sẽ thấy 3 containers chạy:
- web-server (Nginx)
- laravel-app (PHP-FPM)
- mysql-db (MySQL)

## Bước 3: Cài đặt ứng dụng

```powershell
# 1. Cài đặt Composer dependencies
docker-compose exec -T app composer install

# 2. Tạo APP_KEY (đã được tạo sẵn trong .env)
docker-compose exec -T app php artisan key:generate

# 3. Chạy database migrations
docker-compose exec -T app php artisan migrate --force
```

## Bước 4: Truy cập ứng dụng

Mở trình duyệt web và truy cập:
```
http://localhost:8080
```

Bạn sẽ thấy trang welcome của Laravel.

## Bước 5: Các lệnh hữu ích

### Quản lý containers

```powershell
# Xem logs
docker-compose logs -f app
docker-compose logs -f web

# Dừng containers
docker-compose down

# Khởi động lại
docker-compose up -d

# Xóa tất cả (bao gồm database)
docker-compose down -v
```

### Làm việc với database

```powershell
# Chạy migrations
docker-compose exec -T app php artisan migrate

# Tạo bảng mới (migration)
docker-compose exec -T app php artisan make:model Post -m

# Seed database
docker-compose exec -T app php artisan db:seed

# Reset database
docker-compose exec -T app php artisan migrate:reset
```

### Chạy Artisan commands

```powershell
# Tạo controller
docker-compose exec -T app php artisan make:controller PostController

# Tạo model
docker-compose exec -T app php artisan make:model Post

# Tạo request class
docker-compose exec -T app php artisan make:request StorePostRequest

# List routes
docker-compose exec -T app php artisan route:list
```

### Chạy tests

```powershell
# Chạy tất cả tests
docker-compose exec -T app php artisan test

# Chạy một test cụ thể
docker-compose exec -T app php artisan test tests/Feature/ExampleTest.php
```

## Truy cập MySQL Database

```powershell
# Kết nối vào MySQL container
docker-compose exec db mysql -u user -p

# Nhập password: secret

# Hiển thị tất cả databases
SHOW DATABASES;

# Sử dụng laravel database
USE laravel;

# Hiển thị tất cả tables
SHOW TABLES;
```

## Cấu hình files

### docker-compose.yml
- Định nghĩa các services (web, app, db)
- Cấu hình ports, volumes, environment
- Điều chỉnh cấu hình database ở đây

### Dockerfile
- Sử dụng PHP 8.2-FPM Alpine
- Cài đặt PHP extensions
- Cài đặt Composer

### nginx/nginx.conf
- Cấu hình web server
- Điểm vào là `/var/www/html/public`
- Forward requests đến PHP-FPM

### src/.env
- Biến môi trường ứng dụng
- Thay đổi các cài đặt database, mail, etc.

## Troubleshooting

### Docker Desktop không chạy
- Bật Hyper-V hoặc WSL2
- Khởi động lại Docker Desktop

### Containers không khởi động
```powershell
# Xem logs lỗi
docker-compose logs

# Kiểm tra cổng 8080 đã được sử dụng
netstat -ano | findstr :8080
```

### Database connection error
```powershell
# Kiểm tra MySQL container
docker-compose logs db

# Đảm bảo mysql-db container đang chạy
docker-compose ps
```

### Permission denied errors
```powershell
# Restart containers
docker-compose down
docker-compose up -d
```

## Backup và Restore Database

### Backup
```powershell
docker-compose exec db mysqldump -u user -p laravel > backup.sql
# Nhập password: secret
```

### Restore
```powershell
docker-compose exec -T db mysql -u user -p laravel < backup.sql
# Nhập password: secret
```

## Tiếp theo

- Tạo routes mới trong `src/routes/web.php`
- Tạo controllers, models, migrations
- Tạo views trong `src/resources/views`
- Chạy tests để đảm bảo quality

Chúc bạn có một trải nghiệm phát triển ứng dụng Laravel thành công! 🚀
