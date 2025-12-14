# 🐳 Hướng dẫn Chạy Ứng dụng trên Docker

## 📌 Tóm tắt nhanh

Bạn cần làm **4 bước** để chạy ứng dụng trên Docker:

| Bước | Hành động | Lệnh |
|------|---------|------|
| 1️⃣ | Clone repository | `git clone ...` |
| 2️⃣ | Khởi động Docker containers | `docker-compose up -d` |
| 3️⃣ | Cài dependencies & setup DB | `docker-compose exec app ...` |
| 4️⃣ | Truy cập ứng dụng | http://localhost:8080 |

---

## 🎬 Chi tiết từng bước

### ✅ Bước 1: Chuẩn bị (Nếu chưa có project)

#### 1a. Cài đặt Docker
- [Download Docker Desktop](https://www.docker.com/products/docker-desktop) (Windows/Mac)
- Hoặc cài Docker trên Linux: `sudo apt install docker.io docker-compose`
- Kiểm tra: `docker --version` và `docker-compose --version`

#### 1b. Clone Repository
```bash
git clone git@github.com:04ngohaitrieu-ux/laravel-docker-app.git
cd laravel-docker-app
```

**Nếu SSH không hoạt động, dùng HTTPS:**
```bash
git clone https://github.com/04ngohaitrieu-ux/laravel-docker-app.git
cd laravel-docker-app
```

---

### ⚙️ Bước 2: Khởi động Docker Containers

#### 2a. Build & Start all services (Nginx, PHP-FPM, MySQL)
```bash
docker-compose up -d
```

**Output:**
```
Creating mysql-db ... done
Creating laravel-app ... done
Creating web-server ... done
```

**Chờ ~30 giây** để MySQL khởi động hoàn toàn (status = "healthy").

#### 2b. Kiểm tra status của các containers
```bash
docker-compose ps
```

**Mong muốn thấy:**
```
NAME          IMAGE                STATUS        PORTS
web-server    nginx:stable-alpine  Up 1 min      0.0.0.0:8080->80/tcp
laravel-app   project-laravel-app  Up 1 min      9000/tcp
mysql-db      mysql:8.0            Up 1 min      3306/tcp
```

---

### 📦 Bước 3: Cài Composer Dependencies & Setup Database

#### 3a. Cài Composer packages (nếu vendor/ trống)
```bash
docker-compose exec app composer install
```

**Output:**
```
Loading composer repositories with package information
...
Generating optimized autoload files
```

#### 3b. Generate APP_KEY (nếu chưa có)
```bash
docker-compose exec app php artisan key:generate
```

**Output:**
```
Application key set successfully.
```

#### 3c. Chạy Database Migrations (tạo tables)
```bash
docker-compose exec app php artisan migrate --force
```

**Output:**
```
Migrating: 2014_10_12_000000_create_users_table
Migrated:  2014_10_12_000000_create_users_table
Migrating: 2014_10_12_100000_create_password_resets_table
Migrated:  2014_10_12_100000_create_password_resets_table
...
Migration table created successfully.
```

✅ **Xong!** Database đã sẵn sàng.

---

### 🌐 Bước 4: Truy cập Ứng dụng

#### Mở browser:
```
http://localhost:8080
```

**Nếu thấy trang Laravel Welcome** → ✅ **Thành công!**

#### Test bằng lệnh (Windows PowerShell):
```bash
curl http://localhost:8080
```

**Output (Status Code 200):**
```
StatusCode        : 200
StatusDescription : OK
```

---

## 🔧 Lệnh Hữu Ích (Hàng ngày)

### 🟢 Khởi động Docker
```bash
docker-compose up -d
```

### 🔴 Dừng Docker
```bash
docker-compose stop
```

### 🔄 Restart Docker
```bash
docker-compose restart
```

### 🗑️ Dừng & Xoá containers (lưu database)
```bash
docker-compose down
```

### ⚠️ Dừng & Xoá mọi thứ (MẤT DATABASE!)
```bash
docker-compose down -v
```

---

## 📊 Truy cập MySQL Database

### Cách 1: Từ Terminal (trong container)
```bash
docker-compose exec db mysql -u user -p laravel
# Password: secret
```

**Lệnh SQL:**
```sql
SHOW TABLES;
SELECT * FROM users;
```

### Cách 2: MySQL GUI Client (DBeaver, MySQL Workbench, etc)
```
Host:     127.0.0.1
Port:     3306
Username: user
Password: secret
Database: laravel
```

---

## 📋 Xem Logs & Debug

### Logs ứng dụng (Laravel)
```bash
docker-compose logs app -f
```

### Logs Nginx (Web server)
```bash
docker-compose logs web -f
```

### Logs MySQL (Database)
```bash
docker-compose logs db -f
```

### Logs tất cả services
```bash
docker-compose logs -f
```

**Ctrl+C** để thoát khỏi logs.

---

## 🛠️ Truy cập Shell (Terminal) của Containers

### Shell của PHP-FPM (Laravel app)
```bash
docker-compose exec app sh
```

Sau đó chạy Laravel Artisan commands:
```bash
php artisan tinker                    # PHP interactive shell
php artisan list                      # Xem tất cả commands
php artisan cache:clear              # Clear cache
php artisan config:clear             # Clear config
```

### Shell của Nginx
```bash
docker-compose exec web sh
```

### Shell của MySQL
```bash
docker-compose exec db bash
```

**Exit shell:**
```bash
exit
```

---

## 🐛 Troubleshooting

### ❌ Lỗi: "Port 8080 already in use"
**Giải pháp:** Thay đổi port trong `docker-compose.yml`:
```yaml
ports:
  - "8081:80"  # Thay 8080 thành 8081
```

Rồi:
```bash
docker-compose down
docker-compose up -d
```

Truy cập: http://localhost:8081

---

### ❌ Lỗi: "MySQL connection refused"
**Giải pháp:** MySQL chưa khởi động hết, chờ 30 giây rồi retry.

Hoặc restart MySQL:
```bash
docker-compose restart db
```

---

### ❌ Lỗi: "vendor/autoload.php not found"
**Giải pháp:** Cài lại Composer:
```bash
docker-compose exec app rm -rf vendor
docker-compose exec app composer install
```

---

### ❌ Lỗi: "SQLSTATE[HY000] [1045] Access denied"
**Giải pháp:** Kiểm tra `.env` file:
```bash
cat src/.env | grep DB_
```

Đảm bảo khớp với `docker-compose.yml`:
```env
DB_HOST=db
DB_DATABASE=laravel
DB_USERNAME=user
DB_PASSWORD=secret
```

---

### ❌ Lỗi: "No such file or directory: Dockerfile"
**Giải pháp:** Đảm bảo bạn đang ở đúng thư mục:
```bash
cd laravel-docker-app
ls Dockerfile docker-compose.yml
```

---

## 📁 Cấu trúc Project

```
laravel-docker-app/
├── docker-compose.yml          # Main Docker config
├── Dockerfile                  # PHP 8.2-FPM image
├── nginx/
│   └── nginx.conf              # Nginx config
├── src/                        # Laravel application folder
│   ├── app/
│   ├── config/
│   ├── database/migrations/    # Database migrations
│   ├── routes/
│   ├── public/
│   ├── .env                    # Environment config (đã cấu hình)
│   ├── composer.json
│   └── ...
├── QUICK_START.md              # This file
├── README.md                   # Project overview
├── SETUP.md                    # Detailed setup
└── DEPLOYMENT.md               # Production guide
```

---

## ✅ Checklist: Ứng dụng Chạy Thành Công

Kiểm tra tất cả điều này:

- [ ] Docker Desktop/Engine chạy
- [ ] `docker-compose ps` - tất cả 3 services "Up"
- [ ] `http://localhost:8080` - hiển thị Laravel welcome page (HTTP 200)
- [ ] `docker-compose exec app php artisan migrate --force` - migrations thành công
- [ ] Có thể truy cập MySQL từ client
- [ ] `docker-compose logs app` - không có lỗi PHP Fatal

**Nếu tất cả OK → 🎉 Ứng dụng sẵn sàng phát triển!**

---

## 🚀 Bước Tiếp Theo

1. **Phát triển ứng dụng:**
   - Chỉnh sửa file trong folder `src/`
   - Thay đổi tự động được reflect (hot reload)

2. **Tạo model & migration:**
   ```bash
   docker-compose exec app php artisan make:model Post -m
   docker-compose exec app php artisan migrate --force
   ```

3. **Tạo controller:**
   ```bash
   docker-compose exec app php artisan make:controller PostController
   ```

4. **Test API/Routes:**
   ```bash
   docker-compose exec app php artisan tinker
   ```

---

## 📞 Tham khảo thêm

- [Docker Documentation](https://docs.docker.com/)
- [Docker Compose Guide](https://docs.docker.com/compose/)
- [Laravel Documentation](https://laravel.com/docs)
- [PHP-FPM Info](https://www.php.net/manual/en/install.fpm.php)

---

**Chúc bạn code vui vẻ! 🎉**
