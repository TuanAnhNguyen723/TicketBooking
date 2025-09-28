@extends('layouts.app')

@section('title', 'Giỏ hàng')

@section('content')
<!-- Page Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h1 class="h3 mb-2 fw-bold text-primary">
                    <i class="fas fa-shopping-cart me-3"></i>
                    Giỏ hàng của bạn
                </h1>
                <p class="text-muted mb-0">Xem lại và chỉnh sửa các vé đã chọn</p>
            </div>
            <div>
                <a href="{{ route('home') }}" class="btn btn-outline-primary">
                    <i class="fas fa-plus me-2"></i>Thêm vé
                </a>
            </div>
        </div>
    </div>
</div>

@if(count($cart) > 0)
    <div class="row">
        <div class="col-lg-8">
            @foreach($cart as $cartKey => $item)
                <div class="modern-cart-item">
                    <div class="cart-item-header">
                        <div class="event-image">
                            <img src="{{ asset('images/events/' . $item['event_image']) }}" 
                                 alt="{{ $item['event_name'] }}"
                                 onerror="this.src='https://via.placeholder.com/300x200?text=No+Image'">
                            <div class="ticket-badge">
                                <span>{{ $item['adult_quantity'] + $item['child_quantity'] }} vé</span>
                            </div>
                        </div>
                        <div class="event-info">
                            <h3 class="event-title">{{ $item['event_name'] }}</h3>
                            <div class="event-date">
                                <i class="fas fa-calendar-alt"></i>
                                <span>{{ \Carbon\Carbon::parse($item['visit_date'])->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="cart-item-content">
                        <div class="ticket-grid">
                            <div class="ticket-card adult-card">
                                <div class="ticket-icon">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="ticket-details">
                                    <h4>Người lớn</h4>
                                    <p class="price">{{ number_format($item['adult_price']) }}đ/vé</p>
                                </div>
                                <div class="quantity-control">
                                    <button class="qty-btn minus" onclick="updateQuantity('{{ $cartKey }}', 'adult', -1)">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="number" 
                                           class="qty-input" 
                                           value="{{ $item['adult_quantity'] }}" 
                                           min="0" 
                                           max="10"
                                           data-cart-key="{{ $cartKey }}"
                                           data-type="adult"
                                           data-price="{{ $item['adult_price'] }}"
                                           onchange="updateQuantityFromInput(this)">
                                    <button class="qty-btn plus" onclick="updateQuantity('{{ $cartKey }}', 'adult', 1)">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="ticket-card child-card">
                                <div class="ticket-icon">
                                    <i class="fas fa-child"></i>
                                </div>
                                <div class="ticket-details">
                                    <h4>Trẻ em</h4>
                                    <p class="price">{{ number_format($item['child_price']) }}đ/vé</p>
                                </div>
                                <div class="quantity-control">
                                    <button class="qty-btn minus" onclick="updateQuantity('{{ $cartKey }}', 'child', -1)">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="number" 
                                           class="qty-input" 
                                           value="{{ $item['child_quantity'] }}" 
                                           min="0" 
                                           max="10"
                                           data-cart-key="{{ $cartKey }}"
                                           data-type="child"
                                           data-price="{{ $item['child_price'] }}"
                                           onchange="updateQuantityFromInput(this)">
                                    <button class="qty-btn plus" onclick="updateQuantity('{{ $cartKey }}', 'child', 1)">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="total-card">
                                <div class="total-icon">
                                    <i class="fas fa-calculator"></i>
                                </div>
                                <div class="total-details">
                                    <h4>Tổng tiền</h4>
                                    <p class="total-amount" data-cart-key="{{ $cartKey }}">
                                        <span class="item-total">{{ number_format(($item['adult_quantity'] * $item['adult_price']) + ($item['child_quantity'] * $item['child_price'])) }}đ</span>
                                    </p>
                                </div>
                                <form action="{{ route('cart.remove') }}" method="POST" class="remove-form">
                                    @csrf
                                    <input type="hidden" name="cart_key" value="{{ $cartKey }}">
                                    <button type="submit" class="remove-btn" 
                                            onclick="return confirm('Bạn có chắc muốn xóa vé này?')">
                                        <i class="fas fa-trash"></i>
                                        <span>Xóa</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="col-lg-4">
            <div class="card border-0 shadow-lg sticky-top" style="top: 2rem;">
                <div class="card-header bg-gradient-primary text-white border-0">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-receipt me-2"></i>
                        Tổng kết đơn hàng
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="summary-item mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-medium">Tổng tiền:</span>
                            <strong class="text-success fs-4" id="cart-total">{{ number_format($total) }}đ</strong>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-3">
                        <a href="{{ route('checkout') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-credit-card me-2"></i>Thanh toán ngay
                        </a>
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Tiếp tục đặt vé
                        </a>
                    </div>
                    
                    <div class="mt-4 p-3 bg-light rounded-3">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-info-circle me-2 text-primary mt-1"></i>
                            <div>
                                <small class="text-muted d-block">Giá vé đã bao gồm thuế VAT</small>
                                <small class="text-muted d-block">Thanh toán an toàn và bảo mật</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="row">
        <div class="col-12">
            <div class="text-center py-5">
                <div class="empty-cart">
                    <div class="empty-icon mb-4">
                        <i class="fas fa-shopping-cart fa-4x text-muted"></i>
                    </div>
                    <h3 class="text-muted mb-3">Giỏ hàng trống</h3>
                    <p class="text-muted mb-4">Bạn chưa có vé nào trong giỏ hàng. Hãy khám phá các sự kiện thú vị!</p>
                    <a href="{{ route('home') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-ticket-alt me-2"></i>Đặt vé ngay
                    </a>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection

@section('styles')
<style>
    /* Modern Cart Styles */
    .modern-cart-item {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        margin-bottom: 24px;
        overflow: hidden;
        transition: all 0.3s ease;
        border: 1px solid #f1f5f9;
    }
    
    .modern-cart-item:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 48px rgba(0, 0, 0, 0.12);
    }
    
    .cart-item-header {
        display: flex;
        align-items: center;
        padding: 24px;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-bottom: 1px solid #e2e8f0;
    }
    
    .event-image {
        position: relative;
        width: 120px;
        height: 80px;
        border-radius: 12px;
        overflow: hidden;
        margin-right: 20px;
        flex-shrink: 0;
    }
    
    .event-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .ticket-badge {
        position: absolute;
        top: 8px;
        right: 8px;
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: white;
        padding: 4px 8px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
    }
    
    .event-info {
        flex: 1;
    }
    
    .event-title {
        font-size: 20px;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 8px 0;
        line-height: 1.3;
    }
    
    .event-date {
        display: flex;
        align-items: center;
        color: #64748b;
        font-size: 14px;
        font-weight: 500;
    }
    
    .event-date i {
        margin-right: 8px;
        color: #3b82f6;
    }
    
    .cart-item-content {
        padding: 24px;
    }
    
    .ticket-grid {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 20px;
    }
    
    .ticket-card {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border: 2px solid #e2e8f0;
        border-radius: 16px;
        padding: 20px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .ticket-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        border-radius: 16px 16px 0 0;
    }
    
    .adult-card::before {
        background: linear-gradient(90deg, #3b82f6, #1d4ed8);
    }
    
    .child-card::before {
        background: linear-gradient(90deg, #10b981, #047857);
    }
    
    .ticket-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        border-color: #cbd5e1;
    }
    
    .ticket-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
        font-size: 20px;
        color: white;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    
    .adult-card .ticket-icon {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    }
    
    .child-card .ticket-icon {
        background: linear-gradient(135deg, #10b981, #047857);
    }
    
    .ticket-details h4 {
        font-size: 16px;
        font-weight: 600;
        color: #1e293b;
        margin: 0 0 8px 0;
    }
    
    .ticket-details .price {
        font-size: 14px;
        color: #64748b;
        font-weight: 500;
        margin: 0 0 16px 0;
    }
    
    .quantity-control {
        display: flex;
        align-items: center;
        background: white;
        border-radius: 12px;
        border: 2px solid #e2e8f0;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }
    
    .qty-btn {
        width: 36px;
        height: 36px;
        border: none;
        background: #f8fafc;
        color: #64748b;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        font-size: 12px;
    }
    
    .qty-btn:hover {
        background: #3b82f6;
        color: white;
        transform: scale(1.05);
    }
    
    .qty-input {
        flex: 1;
        border: none;
        text-align: center;
        font-weight: 600;
        font-size: 16px;
        background: white;
        padding: 8px 12px;
        color: #1e293b;
    }
    
    .qty-input:focus {
        outline: none;
        box-shadow: inset 0 0 0 2px #3b82f6;
    }
    
    .total-card {
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        border: 2px solid #0ea5e9;
        border-radius: 16px;
        padding: 20px;
        position: relative;
        overflow: hidden;
    }
    
    .total-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #0ea5e9, #06b6d4);
        border-radius: 16px 16px 0 0;
    }
    
    .total-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: linear-gradient(135deg, #0ea5e9, #06b6d4);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
        font-size: 20px;
        color: white;
        box-shadow: 0 4px 12px rgba(14, 165, 233, 0.3);
    }
    
    .total-details h4 {
        font-size: 16px;
        font-weight: 600;
        color: #1e293b;
        margin: 0 0 8px 0;
    }
    
    .total-amount {
        font-size: 20px;
        font-weight: 700;
        color: #0ea5e9;
        margin: 0 0 16px 0;
    }
    
    .remove-form {
        width: 100%;
    }
    
    .remove-btn {
        width: 100%;
        background: linear-gradient(135deg, #ef4444, #dc2626);
        border: none;
        border-radius: 12px;
        padding: 12px 16px;
        color: white;
        font-weight: 600;
        font-size: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }
    
    .remove-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(239, 68, 68, 0.4);
        background: linear-gradient(135deg, #dc2626, #b91c1c);
    }
    
    .remove-btn:active {
        transform: translateY(0);
    }
    
    .bg-gradient-primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark)) !important;
    }
    
    .total-price {
        background: var(--bg-secondary);
        padding: var(--spacing-md);
        border-radius: var(--radius-lg);
        border: 1px solid var(--gray-200);
    }
    
    .empty-cart {
        padding: var(--spacing-3xl) var(--spacing-xl);
        background: var(--bg-secondary);
        border-radius: var(--radius-2xl);
        border: 2px dashed var(--gray-300);
    }
    
    .empty-icon {
        animation: float 3s ease-in-out infinite;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }
    
    .badge {
        font-size: var(--font-size-sm);
        font-weight: var(--font-weight-semibold);
        padding: var(--spacing-sm) var(--spacing-md);
        border-radius: var(--radius-full);
    }
    
    .card-header {
        border-radius: var(--radius-xl) var(--radius-xl) 0 0 !important;
    }
    
    .sticky-top {
        position: sticky;
        top: 2rem;
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .cart-item-header {
            flex-direction: column;
            text-align: center;
            padding: 20px;
        }
        
        .event-image {
            width: 100%;
            height: 120px;
            margin-right: 0;
            margin-bottom: 16px;
        }
        
        .ticket-grid {
            grid-template-columns: 1fr;
            gap: 16px;
        }
        
        .ticket-card {
            padding: 16px;
        }
        
        .total-card {
            padding: 16px;
        }
        
        .cart-item-content {
            padding: 20px;
        }
        
        .empty-cart {
            padding: var(--spacing-xl) var(--spacing-md);
        }
        
        .sticky-top {
            position: relative !important;
            top: auto !important;
        }
    }
    
    @media (max-width: 480px) {
        .modern-cart-item {
            margin-bottom: 16px;
            border-radius: 16px;
        }
        
        .cart-item-header {
            padding: 16px;
        }
        
        .cart-item-content {
            padding: 16px;
        }
        
        .event-title {
            font-size: 18px;
        }
        
        .ticket-card {
            padding: 12px;
        }
        
        .total-card {
            padding: 12px;
        }
        
        .ticket-icon {
            width: 40px;
            height: 40px;
            font-size: 16px;
        }
        
        .total-icon {
            width: 40px;
            height: 40px;
            font-size: 16px;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    // Add CSRF token to meta tag if not exists
    if (!document.querySelector('meta[name="csrf-token"]')) {
        const meta = document.createElement('meta');
        meta.name = 'csrf-token';
        meta.content = '{{ csrf_token() }}';
        document.head.appendChild(meta);
    }
</script>
<script>
    // AJAX function to update cart quantity
    function updateQuantity(cartKey, type, change) {
        const input = document.querySelector(`input[data-cart-key="${cartKey}"][data-type="${type}"]`);
        const currentValue = parseInt(input.value);
        const newValue = Math.max(0, Math.min(10, currentValue + change));
        
        if (newValue !== currentValue) {
            input.value = newValue;
            
            // Update totals immediately (local calculation)
            calculateItemTotal(cartKey);
            
            // Then try AJAX update
            updateCartItem(cartKey, type, newValue);
        }
    }
    
    // Update quantity from input change
    function updateQuantityFromInput(input) {
        const cartKey = input.dataset.cartKey;
        const type = input.dataset.type;
        const newValue = Math.max(0, Math.min(10, parseInt(input.value) || 0));
        
        input.value = newValue;
        
        // Update totals immediately (local calculation)
        calculateItemTotal(cartKey);
        
        // Then try AJAX update
        updateCartItem(cartKey, type, newValue);
    }
    
    // AJAX call to update cart
    function updateCartItem(cartKey, type, quantity) {
        const formData = new FormData();
        
        // Get CSRF token safely
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (csrfToken) {
            formData.append('_token', csrfToken.getAttribute('content'));
        } else {
            // Fallback: get from form if meta tag not found
            const tokenInput = document.querySelector('input[name="_token"]');
            if (tokenInput) {
                formData.append('_token', tokenInput.value);
            }
        }
        
        formData.append('cart_key', cartKey);
        
        // Get both quantities
        const adultInput = document.querySelector(`input[data-cart-key="${cartKey}"][data-type="adult"]`);
        const childInput = document.querySelector(`input[data-cart-key="${cartKey}"][data-type="child"]`);
        
        if (adultInput && childInput) {
            formData.append('adult_quantity', adultInput.value);
            formData.append('child_quantity', childInput.value);
            
            fetch('{{ route("cart.update") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                console.log('Response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    updateItemTotal(cartKey, data.item_total);
                    updateCartTotal(data.cart_total);
                    
                    // Update badge
                    const badge = document.querySelector(`.ticket-badge span`);
                    if (badge) {
                        badge.textContent = `${data.adult_quantity + data.child_quantity} vé`;
                    }
                    
                    // Show success toast
                    showToast('Đã cập nhật giỏ hàng!', 'success', 1500);
                } else {
                    console.error('Update failed:', data);
                    showToast('Có lỗi khi cập nhật giỏ hàng!', 'error', 2000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Có lỗi xảy ra khi cập nhật giỏ hàng!', 'error', 2000);
            });
        } else {
            console.error('Could not find input elements for cart key:', cartKey);
            showToast('Có lỗi khi tìm thông tin vé!', 'error', 2000);
        }
    }
    
    // Update item total
    function updateItemTotal(cartKey, total) {
        const itemTotalElement = document.querySelector(`.total-amount[data-cart-key="${cartKey}"] .item-total`);
        if (itemTotalElement) {
            itemTotalElement.textContent = new Intl.NumberFormat('vi-VN').format(total) + 'đ';
        }
    }
    
    // Update cart total
    function updateCartTotal(total) {
        const cartTotalElement = document.getElementById('cart-total');
        if (cartTotalElement) {
            cartTotalElement.textContent = new Intl.NumberFormat('vi-VN').format(total) + 'đ';
        }
    }
    
    // Calculate item total locally
    function calculateItemTotal(cartKey) {
        const adultInput = document.querySelector(`input[data-cart-key="${cartKey}"][data-type="adult"]`);
        const childInput = document.querySelector(`input[data-cart-key="${cartKey}"][data-type="child"]`);
        
        if (adultInput && childInput) {
            const adultQty = parseInt(adultInput.value) || 0;
            const childQty = parseInt(childInput.value) || 0;
            
            // Get prices from data attributes
            const adultPrice = parseInt(adultInput.dataset.price) || 0;
            const childPrice = parseInt(childInput.dataset.price) || 0;
            
            const total = (adultQty * adultPrice) + (childQty * childPrice);
            
            // Update item total directly
            const itemTotalElement = document.querySelector(`.total-amount[data-cart-key="${cartKey}"] .item-total`);
            if (itemTotalElement) {
                itemTotalElement.textContent = new Intl.NumberFormat('vi-VN').format(total) + 'đ';
            }
            
            // Update cart total
            calculateCartTotal();
        }
    }
    
    // Calculate cart total locally
    function calculateCartTotal() {
        let total = 0;
        document.querySelectorAll('.item-total').forEach(item => {
            const totalText = item.textContent;
            const itemTotal = parseInt(totalText.replace(/[^\d]/g, '')) || 0;
            total += itemTotal;
        });
        
        updateCartTotal(total);
    }
    
    // Add loading state to remove forms
    document.addEventListener('DOMContentLoaded', function() {
        const removeForms = document.querySelectorAll('form[action*="cart.remove"]');
        removeForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn) {
                    const originalText = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Đang xóa...';
                    submitBtn.disabled = true;
                    
                    // Re-enable after 3 seconds (fallback)
                    setTimeout(() => {
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                    }, 3000);
                }
            });
        });
    });
</script>
@endsection
