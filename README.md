# TicketBooking - Hệ thống đặt vé sự kiện

Hệ thống đặt vé trực tuyến cho các sự kiện và khu vui chơi với giao diện hiện đại và tính năng đầy đủ.

## 🚀 Tính năng chính

- **Đặt vé sự kiện**: Tìm kiếm và đặt vé cho các sự kiện, khu vui chơi
- **Quản lý giỏ hàng**: Thêm, sửa, xóa vé trong giỏ hàng
- **Thanh toán**: Hệ thống thanh toán đơn giản
- **Quản lý đơn hàng**: Theo dõi trạng thái đơn hàng và vé điện tử
- **Đánh giá**: Người dùng có thể đánh giá sự kiện
- **Admin panel**: Quản lý sự kiện, đơn hàng, người dùng
- **Báo cáo**: Thống kê doanh thu và báo cáo

## 📋 Yêu cầu hệ thống

- PHP >= 8.1
- Composer
- MySQL >= 5.7 hoặc MariaDB >= 10.2
- Node.js & NPM (cho frontend assets)
- Web server (Apache/Nginx) hoặc PHP built-in server

## 🛠️ Cài đặt

### 1. Clone repository

```bash
git clone <repository-url>
cd TicketBooking
```

### 2. Cài đặt dependencies

```bash
# Cài đặt PHP dependencies
composer install

# Cài đặt Node.js dependencies (nếu cần)
npm install
```

### 3. Cấu hình môi trường

```bash
# Copy file cấu hình
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Cấu hình database

Chỉnh sửa file `.env` với thông tin database của bạn:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ticketbooking
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 5. Tạo database

```sql
CREATE DATABASE ticketbooking CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 6. Chạy migrations và seeders

```bash
# Chạy migrations để tạo tables
php artisan migrate

# Chạy seeders để tạo dữ liệu mẫu
php artisan db:seed
```

### 7. Tạo storage link (nếu cần)

```bash
php artisan storage:link
```

### 8. Chạy ứng dụng

```bash
# Sử dụng PHP built-in server
php artisan serve

# Hoặc sử dụng web server của bạn
# Truy cập: http://localhost:8000
```

## 📁 Cấu trúc thư mục

```
TicketBooking/
├── app/
│   ├── Http/Controllers/     # Controllers
│   ├── Models/              # Eloquent Models
│   └── Providers/           # Service Providers
├── database/
│   ├── migrations/          # Database migrations
│   └── seeders/            # Database seeders
├── public/
│   ├── images/events/       # Hình ảnh sự kiện
│   └── index.php           # Entry point
├── resources/
│   ├── views/              # Blade templates
│   ├── css/                # CSS files
│   └── js/                 # JavaScript files
└── routes/
    └── web.php             # Web routes
```

## 🎯 Sử dụng

### Người dùng thường

1. **Truy cập trang chủ**: Xem danh sách sự kiện
2. **Tìm kiếm**: Sử dụng thanh tìm kiếm để tìm sự kiện
3. **Xem chi tiết**: Click vào sự kiện để xem thông tin chi tiết
4. **Đặt vé**: Chọn số lượng vé và thêm vào giỏ hàng
5. **Thanh toán**: Hoàn tất thanh toán
6. **Quản lý đơn hàng**: Xem trạng thái đơn hàng và vé điện tử

### Admin

1. **Truy cập admin**: `/admin`
2. **Quản lý sự kiện**: Thêm, sửa, xóa sự kiện
3. **Quản lý đơn hàng**: Xem và cập nhật trạng thái đơn hàng
4. **Quản lý người dùng**: Xem thông tin người dùng
5. **Xem báo cáo**: Thống kê doanh thu và báo cáo

## 🔧 Cấu hình bổ sung

### Mail Configuration

Để gửi email, cấu hình trong `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
```

### Cache Configuration

```env
CACHE_STORE=redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

## 🐛 Troubleshooting

### Lỗi thường gặp

1. **Lỗi database connection**:
   - Kiểm tra thông tin database trong `.env`
   - Đảm bảo MySQL service đang chạy
   - Kiểm tra quyền truy cập database

2. **Lỗi permission**:
   ```bash
   chmod -R 755 storage
   chmod -R 755 bootstrap/cache
   ```

3. **Lỗi hình ảnh không hiển thị**:
   - Kiểm tra thư mục `public/images/events/`
   - Chạy `php artisan storage:link`

4. **Lỗi pagination**:
   - Clear cache: `php artisan view:clear`
   - Clear config: `php artisan config:clear`

### Commands hữu ích

```bash
# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear

# Reset database
php artisan migrate:fresh --seed

# Generate key
php artisan key:generate

# Check routes
php artisan route:list

# Check migrations
php artisan migrate:status
```

## 📝 API Endpoints

### Public Routes

- `GET /` - Trang chủ
- `GET /search` - Tìm kiếm sự kiện
- `GET /events/{event}` - Chi tiết sự kiện
- `POST /events/{event}/book` - Đặt vé
- `GET /cart` - Giỏ hàng
- `POST /cart/update` - Cập nhật giỏ hàng
- `POST /cart/remove` - Xóa vé khỏi giỏ hàng
- `GET /checkout` - Thanh toán
- `POST /checkout/process` - Xử lý thanh toán

### Admin Routes

- `GET /admin` - Dashboard admin
- `GET /admin/events` - Quản lý sự kiện
- `GET /admin/orders` - Quản lý đơn hàng
- `GET /admin/users` - Quản lý người dùng
- `GET /admin/reports/revenue-by-time` - Báo cáo doanh thu

## 🤝 Đóng góp

1. Fork repository
2. Tạo feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Tạo Pull Request

## 📄 License

Distributed under the MIT License. See `LICENSE` for more information.

## 📞 Liên hệ

- Email: your-email@example.com
- Project Link: [https://github.com/your-username/TicketBooking](https://github.com/your-username/TicketBooking)

---

**Lưu ý**: Đây là phiên bản demo. Để sử dụng trong production, hãy cấu hình bảo mật và tối ưu hóa phù hợp.