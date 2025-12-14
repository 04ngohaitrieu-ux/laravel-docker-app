# 📦 GitHub Push Instructions

## 🔧 Cách Push lên GitHub

### Bước 1: Tạo Repository trên GitHub

1. Đăng nhập vào GitHub: https://github.com/login
2. Click "New" để tạo repository mới
3. Điền thông tin:
   - **Repository name**: `project-laravel`
   - **Description**: `Laravel Docker Application`
   - **Visibility**: Public hoặc Private
   - Bỏ chọn "Initialize this repository with"
4. Click "Create repository"

### Bước 2: Thêm Remote và Push

Sau khi tạo repository, GitHub sẽ hiển thị các lệnh. Chạy các lệnh này:

```powershell
cd c:\Users\ACER\docker-projects\project-laravel

# Thêm remote repository (thay <username> và <repo-name>)
git remote add origin https://github.com/<username>/project-laravel.git

# Đặt branch mặc định là main
git branch -M main

# Push code lên GitHub
git push -u origin main
```

### Bước 3: Xác thực GitHub

Nếu được yêu cầu xác thực, bạn có 2 tùy chọn:

#### Tùy chọn A: Personal Access Token (Khuyên dùng)
1. Vào GitHub Settings: https://github.com/settings/tokens
2. Click "Generate new token"
3. Chọn "Generate new token (classic)"
4. Điền:
   - **Note**: `git-push-token`
   - **Expiration**: 90 days
   - **Select scopes**: Chọn `repo` (full control)
5. Click "Generate token"
6. Copy token (chỉ hiển thị một lần)
7. Dùng token này làm password khi push

#### Tùy chọn B: SSH Key
1. Tạo SSH key: 
```powershell
ssh-keygen -t ed25519 -C "your.email@example.com"
```
2. Thêm public key vào GitHub Settings
3. Dùng SSH URL: `git@github.com:<username>/project-laravel.git`

### Bước 4: Xác minh Push thành công

```powershell
# Kiểm tra remote
git remote -v

# Xem log
git log --oneline

# Kết quả:
# origin  https://github.com/<username>/project-laravel.git (fetch)
# origin  https://github.com/<username>/project-laravel.git (push)
```

Sau đó, vào https://github.com/<username>/project-laravel để xác minh code đã được push.

## 📝 Cấu hình Git Global (Lựa chọn)

```powershell
# Cấu hình user trên toàn hệ thống
git config --global user.name "Your Name"
git config --global user.email "your.email@example.com"

# Xác minh cấu hình
git config --global --list
```

## 🔄 Những lệnh hữu ích sau này

```powershell
# Xem branches
git branch -a

# Xem commits
git log --oneline -10

# Push branch mới
git push -u origin <branch-name>

# Pull code từ GitHub
git pull origin main

# Tạo tag và push
git tag v1.0.0
git push origin v1.0.0
```

## ✅ Checklist

- [ ] Tạo repository trên GitHub
- [ ] Copy HTTPS hoặc SSH URL
- [ ] Chạy `git remote add origin <URL>`
- [ ] Chạy `git push -u origin main`
- [ ] Xác minh code trên GitHub

---

**Lưu ý**: Không push file `.env` chứa sensitive data. Nó đã được thêm vào `.gitignore`
