<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Order;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    /**
     * Thêm vé vào giỏ hàng
     */
    public function addToCart(Request $request, Event $event)
    {
        $request->validate([
            'visit_date' => 'required|date|after_or_equal:today',
            'adult_quantity' => 'required|integer|min:0',
            'child_quantity' => 'required|integer|min:0',
        ]);
        
        // Kiểm tra ngày đi có trong khoảng thời gian sự kiện
        if ($request->visit_date < $event->start_date || $request->visit_date > $event->end_date) {
            return back()->with('error', 'Ngày đi không hợp lệ cho sự kiện này.');
        }

        $adultQuantity = (int) $request->adult_quantity;
        $childQuantity = (int) $request->child_quantity;

        if ($adultQuantity === 0 && $childQuantity === 0) {
            return back()->with('error', 'Vui lòng chọn ít nhất 1 vé.');
        }

        // Lấy giỏ hàng từ session
        $cart = Session::get('cart', []);

        // Tạo key duy nhất cho mỗi item trong giỏ hàng
        $cartKey = $event->id . '_' . $request->visit_date;

        if (isset($cart[$cartKey])) {
            // Cập nhật số lượng nếu item đã tồn tại
            $cart[$cartKey]['adult_quantity'] += $adultQuantity;
            $cart[$cartKey]['child_quantity'] += $childQuantity;
        } else {
            // Thêm item mới vào giỏ hàng
            $cart[$cartKey] = [
                'event_id' => $event->id,
                'event_name' => $event->name,
                'event_image' => $event->image,
                'visit_date' => $request->visit_date,
                'adult_quantity' => $adultQuantity,
                'child_quantity' => $childQuantity,
                'adult_price' => $event->adult_price,
                'child_price' => $event->child_price,
            ];
        }

        Session::put('cart', $cart);

        return back()->with('success', 'Đã thêm vé vào giỏ hàng!');
    }

    /**
     * Hiển thị giỏ hàng
     */
    public function cart()
    {
        $cart = Session::get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += ($item['adult_quantity'] * $item['adult_price']) + 
                     ($item['child_quantity'] * $item['child_price']);
        }

        return view('booking.cart', compact('cart', 'total'));
    }

    /**
     * Cập nhật giỏ hàng
     */
    public function updateCart(Request $request)
    {
        $cartKey = $request->cart_key;
        $cart = Session::get('cart', []);

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['adult_quantity'] = (int) $request->adult_quantity;
            $cart[$cartKey]['child_quantity'] = (int) $request->child_quantity;

            // Xóa item nếu số lượng = 0
            if ($cart[$cartKey]['adult_quantity'] === 0 && $cart[$cartKey]['child_quantity'] === 0) {
                unset($cart[$cartKey]);
            }

            Session::put('cart', $cart);
        }

        // Check if it's an AJAX request
        if ($request->ajax()) {
            $item = $cart[$cartKey] ?? null;
            if ($item) {
                $itemTotal = ($item['adult_quantity'] * $item['adult_price']) + ($item['child_quantity'] * $item['child_price']);
                $cartTotal = collect($cart)->sum(function ($item) {
                    return ($item['adult_quantity'] * $item['adult_price']) + ($item['child_quantity'] * $item['child_price']);
                });

                return response()->json([
                    'success' => true,
                    'item_total' => $itemTotal,
                    'cart_total' => $cartTotal,
                    'adult_quantity' => $item['adult_quantity'],
                    'child_quantity' => $item['child_quantity']
                ]);
            }
        }

        return redirect()->route('cart')->with('success', 'Đã cập nhật giỏ hàng!');
    }

    /**
     * Xóa item khỏi giỏ hàng
     */
    public function removeFromCart(Request $request)
    {
        $cartKey = $request->cart_key;
        $cart = Session::get('cart', []);

        if (isset($cart[$cartKey])) {
            unset($cart[$cartKey]);
            Session::put('cart', $cart);
        }

        return redirect()->route('cart')->with('success', 'Đã xóa vé khỏi giỏ hàng!');
    }

    /**
     * Hiển thị trang thanh toán
     */
    public function checkout()
    {
        $cart = Session::get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Giỏ hàng trống!');
        }

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để thanh toán!');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += ($item['adult_quantity'] * $item['adult_price']) + 
                     ($item['child_quantity'] * $item['child_price']);
        }

        return view('booking.checkout', compact('cart', 'total'));
    }

    /**
     * Xử lý thanh toán
     */
    public function processPayment(Request $request)
    {
        $cart = Session::get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Giỏ hàng trống!');
        }

        $request->validate([
            'payment_method' => 'required|in:card,ewallet,qr',
        ]);

        // Tạo đơn hàng
        $order = Order::create([
            'user_id' => Auth::id(),
            'order_number' => 'ORD' . time() . rand(1000, 9999),
            'total_amount' => $this->calculateTotal($cart),
            'status' => 'paid',
            'payment_method' => $request->payment_method,
            'payment_reference' => 'PAY' . time() . rand(1000, 9999),
        ]);

        // Tạo vé cho từng item trong giỏ hàng
        foreach ($cart as $item) {
            // Tạo vé người lớn
            if ($item['adult_quantity'] > 0) {
                for ($i = 0; $i < $item['adult_quantity']; $i++) {
                    Ticket::create([
                        'event_id' => $item['event_id'],
                        'order_id' => $order->id,
                        'type' => 'adult',
                        'quantity' => 1,
                        'price' => $item['adult_price'],
                        'visit_date' => $item['visit_date'],
                        'qr_code' => 'QR' . Str::random(20),
                        'status' => 'paid',
                    ]);
                }
            }

            // Tạo vé trẻ em
            if ($item['child_quantity'] > 0) {
                for ($i = 0; $i < $item['child_quantity']; $i++) {
                    Ticket::create([
                        'event_id' => $item['event_id'],
                        'order_id' => $order->id,
                        'type' => 'child',
                        'quantity' => 1,
                        'price' => $item['child_price'],
                        'visit_date' => $item['visit_date'],
                        'qr_code' => 'QR' . Str::random(20),
                        'status' => 'paid',
                    ]);
                }
            }
        }

        // Xóa giỏ hàng
        Session::forget('cart');

        return redirect()->route('orders.show', $order)->with('success', 'Thanh toán thành công!');
    }

    /**
     * Tính tổng tiền
     */
    private function calculateTotal($cart)
    {
        $total = 0;
        foreach ($cart as $item) {
            $total += ($item['adult_quantity'] * $item['adult_price']) + 
                     ($item['child_quantity'] * $item['child_price']);
        }
        return $total;
    }
}
