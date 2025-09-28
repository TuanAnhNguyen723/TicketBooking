@extends('layouts.app')

@section('title', 'Thanh toán')

@section('content')
<!-- Page Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h1 class="h3 mb-2 fw-bold text-primary">
                    <i class="fas fa-credit-card me-3"></i>
                    Thanh toán
                </h1>
                <p class="text-muted mb-0">Hoàn tất đơn hàng và nhận vé điện tử</p>
            </div>
            <div>
                <a href="{{ route('cart') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Quay lại giỏ hàng
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Order Summary -->
        <div class="card mb-4 border-0 shadow-sm checkout-card">
            <div class="card-header bg-gradient-primary text-white border-0">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-receipt me-2"></i>
                    Thông tin đơn hàng
                </h5>
            </div>
            <div class="card-body p-4">
                @foreach($cart as $item)
                    <div class="row mb-4 pb-4 border-bottom border-light">
                        <div class="col-md-3">
                            <div class="position-relative">
                                <img src="{{ asset('images/events/' . $item['event_image']) }}" 
                                     class="img-fluid rounded-3 shadow-sm" 
                                     style="height: 100px; object-fit: cover; width: 100%;"
                                     alt="{{ $item['event_name'] }}"
                                     onerror="this.src='https://via.placeholder.com/150x100?text=No+Image'">
                                <div class="position-absolute top-0 end-0 m-2">
                                    <span class="badge bg-primary bg-gradient">
                                        {{ $item['adult_quantity'] + $item['child_quantity'] }} vé
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <h6 class="mb-2 fw-bold">{{ $item['event_name'] }}</h6>
                            <p class="text-muted mb-3">
                                <i class="fas fa-calendar-alt me-2 text-primary"></i>
                                <strong>Ngày đi:</strong> {{ \Carbon\Carbon::parse($item['visit_date'])->format('d/m/Y') }}
                            </p>
                            <div class="row">
                                @if($item['adult_quantity'] > 0)
                                    <div class="col-6">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-user me-2 text-primary"></i>
                                            <span class="small text-muted">
                                                <strong>Người lớn:</strong> {{ $item['adult_quantity'] }} vé × {{ number_format($item['adult_price']) }}đ
                                            </span>
                                        </div>
                                    </div>
                                @endif
                                @if($item['child_quantity'] > 0)
                                    <div class="col-6">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-child me-2 text-success"></i>
                                            <span class="small text-muted">
                                                <strong>Trẻ em:</strong> {{ $item['child_quantity'] }} vé × {{ number_format($item['child_price']) }}đ
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        
        <!-- Payment Method -->
        <div class="card border-0 shadow-sm checkout-card">
            <div class="card-header bg-gradient-primary text-white border-0">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-payment me-2"></i>
                    Phương thức thanh toán
                </h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('checkout.process') }}" method="POST" id="paymentForm">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="payment-method-option">
                                <input class="form-check-input" type="radio" name="payment_method" value="card" id="card" checked>
                                <label class="form-check-label payment-label" for="card">
                                    <div class="payment-icon">
                                        <i class="fas fa-credit-card"></i>
                                    </div>
                                    <div class="payment-text">
                                        <strong>Thẻ tín dụng</strong>
                                        <small>Visa, Mastercard</small>
                                    </div>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="payment-method-option">
                                <input class="form-check-input" type="radio" name="payment_method" value="ewallet" id="ewallet">
                                <label class="form-check-label payment-label" for="ewallet">
                                    <div class="payment-icon">
                                        <i class="fas fa-wallet"></i>
                                    </div>
                                    <div class="payment-text">
                                        <strong>Ví điện tử</strong>
                                        <small>MoMo, ZaloPay</small>
                                    </div>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="payment-method-option">
                                <input class="form-check-input" type="radio" name="payment_method" value="qr" id="qr">
                                <label class="form-check-label payment-label" for="qr">
                                    <div class="payment-icon">
                                        <i class="fas fa-qrcode"></i>
                                    </div>
                                    <div class="payment-text">
                                        <strong>QR Code</strong>
                                        <small>Quét mã thanh toán</small>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Payment Details (simulated) -->
                    <div id="paymentDetails" class="mt-4">
                        
                        <div class="payment-details-card p-4 bg-light rounded-3">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-medium">Số thẻ (mô phỏng)</label>
                                    <input type="text" class="form-control" value="1234 5678 9012 3456" readonly>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label fw-medium">Ngày hết hạn</label>
                                    <input type="text" class="form-control" value="12/25" readonly>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label fw-medium">CVV</label>
                                    <input type="text" class="form-control" value="123" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-success btn-lg payment-btn">
                            <i class="fas fa-check me-2"></i>
                            Xác nhận thanh toán
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Order Total -->
        <div class="card border-0 shadow-lg sticky-top" style="top: 2rem;">
            <div class="card-header bg-gradient-primary text-white border-0">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-calculator me-2"></i>
                    Tổng kết đơn hàng
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="summary-item mb-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="fw-medium">Tạm tính:</span>
                        <span>{{ number_format($total) }}đ</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="fw-medium">Thuế VAT (10%):</span>
                        <span>{{ number_format($total * 0.1) }}đ</span>
                    </div>
                    <hr class="my-3">
                    <div class="d-flex justify-content-between">
                        <strong>Tổng cộng:</strong>
                        <strong class="text-success fs-4">{{ number_format($total * 1.1) }}đ</strong>
                    </div>
                </div>
                
            </div>
        </div>
        
        <!-- User Info -->
        <div class="card mt-4 border-0 shadow-sm">
            <div class="card-header bg-light border-0">
                <h6 class="mb-0 fw-bold text-primary">
                    <i class="fas fa-user me-2"></i>
                    Thông tin người đặt
                </h6>
            </div>
            <div class="card-body p-4">
                <div class="user-info">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-id-card me-2 text-primary"></i>
                        <span class="fw-medium">Tên:</span>
                        <span class="ms-2">{{ Auth::user()->name }}</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-envelope me-2 text-primary"></i>
                        <span class="fw-medium">Email:</span>
                        <span class="ms-2">{{ Auth::user()->email }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Checkout Page Custom Styles */
    .checkout-card {
        transition: all var(--transition-normal);
        border: 1px solid var(--gray-200);
    }
    
    .checkout-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-xl) !important;
    }
    
    .bg-gradient-primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark)) !important;
    }
    
    .payment-method-option {
        position: relative;
    }
    
    .payment-method-option input[type="radio"] {
        position: absolute;
        opacity: 0;
    }
    
    .payment-label {
        display: flex;
        align-items: center;
        padding: var(--spacing-md);
        border: 2px solid var(--gray-200);
        border-radius: var(--radius-lg);
        cursor: pointer;
        transition: all var(--transition-normal);
        background: var(--bg-primary);
    }
    
    .payment-label:hover {
        border-color: var(--primary);
        box-shadow: var(--shadow-sm);
    }
    
    .payment-method-option input[type="radio"]:checked + .payment-label {
        border-color: var(--primary);
        background: var(--primary-light);
        box-shadow: var(--shadow-md);
    }
    
    .payment-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--primary);
        color: white;
        border-radius: var(--radius-lg);
        margin-right: var(--spacing-md);
        font-size: var(--font-size-lg);
    }
    
    .payment-text {
        flex: 1;
    }
    
    .payment-text strong {
        display: block;
        margin-bottom: var(--spacing-xs);
    }
    
    .payment-text small {
        color: var(--text-muted);
    }
    
    .payment-details-card {
        border: 1px solid var(--gray-200);
        transition: all var(--transition-normal);
    }
    
    .payment-details-card:hover {
        border-color: var(--primary);
        box-shadow: var(--shadow-sm);
    }
    
    .payment-btn {
        position: relative;
        overflow: hidden;
    }
    
    .payment-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }
    
    .payment-btn:hover::before {
        left: 100%;
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
    
    .border-light {
        border-color: var(--gray-200) !important;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .checkout-card .col-md-3 {
            margin-top: var(--spacing-lg);
        }
        
        .payment-label {
            flex-direction: column;
            text-align: center;
        }
        
        .payment-icon {
            margin-right: 0;
            margin-bottom: var(--spacing-sm);
        }
        
        .sticky-top {
            position: relative !important;
            top: auto !important;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const paymentMethodRadios = document.querySelectorAll('input[name="payment_method"]');
        const paymentDetails = document.getElementById('paymentDetails');
        
        paymentMethodRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'card') {
                    paymentDetails.innerHTML = `
                        <div class="payment-details-card p-4 bg-light rounded-3">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-medium">Số thẻ (mô phỏng)</label>
                                    <input type="text" class="form-control" value="1234 5678 9012 3456" readonly>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label fw-medium">Ngày hết hạn</label>
                                    <input type="text" class="form-control" value="12/25" readonly>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label fw-medium">CVV</label>
                                    <input type="text" class="form-control" value="123" readonly>
                                </div>
                            </div>
                        </div>
                    `;
                } else if (this.value === 'ewallet') {
                    paymentDetails.innerHTML = `
                        <div class="payment-details-card p-4 bg-light rounded-3">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="form-label fw-medium">Ví điện tử (mô phỏng)</label>
                                    <select class="form-select" disabled>
                                        <option>MoMo</option>
                                        <option>ZaloPay</option>
                                        <option>VNPay</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    `;
                } else if (this.value === 'qr') {
                    paymentDetails.innerHTML = `
                        <div class="payment-details-card p-4 bg-light rounded-3 text-center">
                            <div class="qr-code-container border-2 border-primary rounded-3 p-4 d-inline-block">
                                <i class="fas fa-qrcode fa-4x text-primary mb-3"></i>
                                <p class="mb-0 fw-bold text-primary">QR Code mô phỏng</p>
                            </div>
                        </div>
                    `;
                }
            });
        });
        
        // Add loading state to payment button
        const paymentForm = document.getElementById('paymentForm');
        const paymentBtn = document.querySelector('.payment-btn');
        
        paymentForm.addEventListener('submit', function(e) {
            const originalText = paymentBtn.innerHTML;
            paymentBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Đang xử lý thanh toán...';
            paymentBtn.disabled = true;
            
            // Re-enable after 3 seconds (fallback)
            setTimeout(() => {
                paymentBtn.innerHTML = originalText;
                paymentBtn.disabled = false;
            }, 3000);
        });
    });
</script>
@endsection
