## TicketBooking - Hướng dẫn Setup nhanh (Windows/Git Bash)

### Yêu cầu hệ thống
- **PHP 8.2+**, Composer 2.x
- **Node.js 18+** và npm (cho Vite asset)
- SQLite (tích hợp sẵn) hoặc MySQL nếu bạn tự cấu hình

### 1) Clone source
```bash
git clone <your-repo-url> TicketBooking
cd TicketBooking
```

### 2) Cài PHP dependencies
```bash
composer install -o -n
```

Nếu gặp lỗi file bị khóa trên Windows, dừng tiến trình rồi chạy lại:
```bash
taskkill /IM php.exe /F 2>nul | true
taskkill /IM composer.exe /F 2>nul | true
composer install -o -n
```

### 3) Tạo file môi trường và APP_KEY
```bash
cp .env.example .env  # nếu .env chưa tồn tại
php artisan key:generate
```

Thiết lập một số biến khuyến nghị trong `.env`:
```
APP_NAME="TicketBooking"
APP_ENV=local
APP_URL=http://127.0.0.1:8000

# Sử dụng SQLite mặc định (đơn giản, không cần cài DB server)
DB_CONNECTION=sqlite
DB_DATABASE="database/database.sqlite"
```

### 4) Cấu hình cơ sở dữ liệu

Bạn có thể chọn MySQL (khuyến nghị khi dùng XAMPP) hoặc SQLite (nhanh, đơn giản).

#### a) MySQL với XAMPP (khuyến nghị)
1. Mở XAMPP Control Panel → Start Apache và MySQL.
2. Mở phpMyAdmin (`http://localhost/phpmyadmin`) → tạo database tên `ticketbooking` (Collation: `utf8mb4_general_ci`).
3. Cập nhật `.env` như sau:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ticketbooking
DB_USERNAME=root
DB_PASSWORD=
```
4. Chạy migrate + seed:
```bash
php artisan migrate:fresh --seed
```

#### b) SQLite (tuỳ chọn nếu không dùng MySQL)
Tạo file database SQLite:
```bash
mkdir -p database
touch database/database.sqlite
```

Hoặc nếu dùng MySQL, chỉnh lại các biến `DB_HOST/DB_PORT/DB_DATABASE/DB_USERNAME/DB_PASSWORD` trong `.env`.

### 5) Chạy migrate + seed dữ liệu mẫu
```bash
php artisan migrate:fresh --seed
```

Seeder sẽ tạo sẵn 5 sự kiện với hình ảnh trỏ tới thư mục `public/images/events` đã có trong repo.

### 6) Cài frontend dependencies và build asset (tùy chọn cho dev)
```bash
npm install
npm run dev   # chạy Vite dev server (hot reload)
# hoặc build production
# npm run build
```

### 7) Chạy ứng dụng
```bash
php artisan serve
# Mở trình duyệt: http://127.0.0.1:8000
```

### Ghi chú
- Ảnh tĩnh nằm tại `public/images/events`, blade sử dụng `asset('images/events/...')` nên chỉ cần `APP_URL` đúng.
- Nếu ảnh không hiển thị, kiểm tra tab Network xem có lỗi 404 tới đường dẫn `images/events/...` và đảm bảo bạn truy cập đúng host/port như trong `APP_URL`.
- Không commit `.env` lên git. Mỗi môi trường nên giữ `APP_KEY` ổn định.

### Lệnh tiện ích
```bash
# Xóa cache cấu hình/ứng dụng nếu đổi .env
php artisan config:clear && php artisan cache:clear

# Reset DB và seed lại
php artisan migrate:fresh --seed
```
