## 🔄 Workflow phát triển

### 🚀 1. Setup ban đầu

```bash
# Clone repository
git clone https://github.com/yourusername/lms.git
cd lms

# Cài đặt dependencies
composer install
npm install

# Copy và cấu hình .env
cp .env.example .env
# Cấu hình database trong .env

# Generate application key
php artisan key:generate

# Chạy migration
php artisan migrate

# Chạy seeder (nếu có)
php artisan db:seed
```

### 🌱 2. Bắt đầu feature mới

```bash
# Đảm bảo đang ở main branch và cập nhật
git checkout main
git pull origin main

# Tạo branch mới cho feature
git checkout -b feature/ten-feature-cua-ban
```

**Ví dụ tên branch:**
```bash
git checkout -b feature/student-dashboard
git checkout -b feature/quiz-system  
git checkout -b feature/course-builder
git checkout -b bugfix/payment-error
git checkout -b hotfix/security-patch
```

### 💻 3. Làm việc và commit

```bash
# Kiểm tra status
git status

# Thêm files vào staging
git add .
# hoặc add từng file cụ thể
git add app/Http/Controllers/CourseController.php

# Commit với message rõ ràng
git commit -m "Mô tả ngắn gọn về thay đổi"
```

**Ví dụ commit messages tốt:**
```bash
git commit -m "feat: add student registration form"
git commit -m "fix: resolve payment validation bug"
git commit -m "feat: implement course video player"
git commit -m "refactor: optimize database queries"
git commit -m "docs: update API documentation"
```

### 📤 4. Push branch và tạo Pull Request

```bash
# Push branch lên GitHub
git push origin feature/ten-feature-cua-ban

# Nếu lần đầu push branch mới
git push -u origin feature/ten-feature-cua-ban
```

**Sau đó:**
1. Vào GitHub repository
2. Click nút **"Compare & pull request"**
3. Viết mô tả chi tiết về changes
4. Assign reviewer (thường là team lead)
5. Add labels nếu cần
6. Click **"Create pull request"**

### 📋 Branch Naming Convention

| Loại | Format | Ví dụ |
|------|--------|-------|
| Feature mới | `feature/ten-tinh-nang` | `feature/admin-dashboard` |
| Bug fix | `bugfix/ten-bug` | `bugfix/login-validation` |
| Hot fix | `hotfix/ten-hotfix` | `hotfix/security-patch` |
| Refactor | `refactor/ten-refactor` | `refactor/user-service` |

### 💡 Commit Message Convention

```
<type>(<scope>): <subject>

<body>

<footer>
```

**Types:**
- `feat`: Tính năng mới
- `fix`: Sửa bug
- `docs`: Cập nhật documentation
- `style`: Format code, không thay đổi logic
- `refactor`: Tái cấu trúc code
- `test`: Thêm hoặc sửa tests
- `chore`: Cập nhật build tools, dependencies

> **⚠️ QUAN TRỌNG:** Tuyệt đối không push trực tiếp lên branch `main`. Mọi thay đổi phải thông qua Pull Request và được review trước khi merge!
