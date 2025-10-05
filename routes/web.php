<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\EventController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\EventAdminController;
use App\Http\Controllers\Admin\OrderAdminController;
use App\Http\Controllers\Admin\TicketAdminController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\Admin\ReviewAdminController;

// Trang chủ - hiển thị danh sách sự kiện
Route::get('/', [EventController::class, 'index'])->name('home');

// Tìm kiếm sự kiện
Route::get('/search', [EventController::class, 'search'])->name('events.search');

// Chi tiết sự kiện
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
// Kiểm tra số vé còn lại theo ngày
Route::get('/events/{event}/availability', [EventController::class, 'availability'])->name('events.availability');

// Đặt vé
Route::post('/events/{event}/book', [BookingController::class, 'addToCart'])->name('booking.add-to-cart');

// Giỏ hàng
Route::get('/cart', [BookingController::class, 'cart'])->name('cart');
Route::post('/cart/update', [BookingController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/remove', [BookingController::class, 'removeFromCart'])->name('cart.remove');

// Thanh toán
Route::get('/checkout', [BookingController::class, 'checkout'])->name('checkout');
Route::post('/checkout/process', [BookingController::class, 'processPayment'])->name('checkout.process');

// Quản lý đơn hàng
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

// Đánh giá
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

// Authentication routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();
        return redirect()->intended('/');
    }

    return back()->withErrors([
        'email' => 'Thông tin đăng nhập không chính xác.',
    ])->onlyInput('email');
})->name('login.post');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', function (Illuminate\Http\Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ]);

    $user = App\Models\User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    Auth::login($user);

    return redirect('/');
})->name('register.post');

Route::post('/logout', function (Illuminate\Http\Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// Khu vực quản trị đơn giản (không cần phân quyền theo yêu cầu)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::redirect('/', '/admin/events');

    // CRUD cơ bản cho các thực thể
    Route::resource('events', EventAdminController::class);
    Route::resource('orders', OrderAdminController::class)->only(['index', 'show', 'edit', 'update', 'destroy']);
    Route::resource('tickets', TicketAdminController::class)->only(['index', 'show', 'edit', 'update', 'destroy']);
    Route::resource('users', UserAdminController::class)->only(['index', 'show', 'edit', 'update', 'destroy']);
    Route::resource('reviews', ReviewAdminController::class)->only(['index', 'show', 'edit', 'update', 'destroy']);
});
