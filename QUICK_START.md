# 🚀 Quick Start Guide - Laravel Docker Project

## Hướng dẫn pull và chạy dự án

### 📋 Yêu cầu hệ thống
- **Docker**: [Download](https://www.docker.com/products/docker-desktop) (Desktop)
- **Docker Compose**: Đã bao gồm trong Docker Desktop
- **Git**: [Download](https://git-scm.com/download/win)

---

## 🔧 Bước 1: Clone Repository

```bash
git clone git@github.com:04ngohaitrieu-ux/laravel-docker-app.git
cd laravel-docker-app
```

**Lỗi SSH?** Nếu gặp lỗi, dùng HTTPS thay thế:
```bash
git clone https://github.com/04ngohaitrieu-ux/laravel-docker-app.git
cd laravel-docker-app
```

---

## 🐳 Bước 2: Chạy Docker Containers

### Khởi động tất cả services (Nginx, PHP-FPM, MySQL):
```bash
docker-compose up -d
```

**Chờ ~30 giây** để MySQL khởi động hoàn toàn.

### Kiểm tra status:
```bash
docker-compose ps
```

**Output mong muốn:**
```
NAME               STATUS
web-server         Up 2 minutes
laravel-app        Up 2 minutes
mysql-db           Up 2 minutes (healthy)
```

---

## ⚙️ Bước 3: Cài đặt Dependencies & Khởi tạo Database

### 3a. Cài đặt Composer dependencies:
```bash
docker-compose exec app composer install
```

### 3b. Generate APP_KEY (nếu cần):
```bash
docker-compose exec app php artisan key:generate
```

### 3c. Chạy Database Migrations:
```bash
docker-compose exec app php artisan migrate --force
```

**Expected output:**
```
Migrating: 2014_10_12_000000_create_users_table
Migrated:  2014_10_12_000000_create_users_table (xxx ms)
...
```

---

## 🌐 Bước 4: Truy cập Ứng dụng

Mở browser và truy cập:
```
http://localhost:8080
```

**Nếu thấy trang Laravel Welcome** → ✅ Thành công!

---

## 📊 Database Connection

| Thông số | Giá trị |
|---------|--------|
| **Host** | `db` (từ trong container) hoặc `127.0.0.1` |
| **Port** | `3306` |
| **Database** | `laravel` |
| **Username** | `user` |
| **Password** | `secret` |
| **Root Password** | `secret` |

### Kết nối từ máy host (MySQL Workbench, DBeaver, etc):
```
Host: 127.0.0.1
Port: 3306
Username: user
Password: secret
Database: laravel
```

---

## 🛠️ Các lệnh hữu ích

### Xem logs ứng dụng:
```bash
docker-compose logs app -f
```

### Xem logs Nginx:
```bash
docker-compose logs web -f
```

### Xem logs MySQL:
```bash
docker-compose logs db -f
```

### Truy cập shell Laravel app:
```bash
docker-compose exec app sh
```

### Truy cập MySQL CLI từ container:
```bash
docker-compose exec db mysql -u user -p laravel
# Password: secret
```

### Dừng all containers:
```bash
docker-compose down
```

### Dừng và xoá data (CẢNH BÁO: Mất tất cả database):
```bash
docker-compose down -v
```

---

## 🐛 Troubleshooting

### ❌ Port 8080 đã bị dùng
```bash
# Thay đổi port trong docker-compose.yml
# Tìm: ports: - "8080:80"
# Sửa: ports: - "8081:80"
# Sau đó: docker-compose up -d
```

### ❌ MySQL không khởi động
```bash
# Kiểm tra logs
docker-compose logs db

# Xoá volume cũ và tạo lại
docker-compose down -v
docker-compose up -d
```

### ❌ "SQLSTATE[HY000] [2002] Connection refused"
```bash
# MySQL chưa sẵn sàng, chờ 30 giây rồi thử lại
# Hoặc restart MySQL
docker-compose restart db
```

### ❌ "Composer install" lỗi
```bash
# Xoá vendor folder và thử lại
docker-compose exec app rm -rf vendor
docker-compose exec app composer install
```

---

## 📁 Cấu trúc thư mục

```
laravel-docker-app/
├── docker-compose.yml      # Docker configuration
├── Dockerfile              # PHP 8.2-FPM image
├── nginx/
│   └── nginx.conf          # Nginx config
├── src/                    # Laravel application
│   ├── app/
│   ├── config/
│   ├── database/
│   ├── routes/
│   ├── public/
│   ├── .env                # Environment config (đã cấu hình)
│   └── ...
├── README.md               # Project overview
├── SETUP.md                # Detailed setup guide
└── QUICK_START.md          # This file
```

---

## ✅ Checklist sau khi chạy

- [ ] `docker-compose ps` - tất cả services "Up"
- [ ] `http://localhost:8080` - hiển thị Laravel trang chủ
- [ ] `docker-compose exec app php artisan tinker` - Laravel console hoạt động
- [ ] Database migrations hoàn thành
- [ ] Có thể truy cập MySQL từ MySQL client

---

## 📞 Cần giúp đỡ?

Xem tài liệu chi tiết:
- **SETUP.md** - Hướng dẫn chi tiết
- **DEPLOYMENT.md** - Hướng dẫn production
- **README.md** - Tổng quan dự án

---

**Happy Coding! 🎉**
