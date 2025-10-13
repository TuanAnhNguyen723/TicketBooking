@extends('layouts.app')

@section('title', 'Chi tiết đơn hàng #' . $order->order_number)

@section('content')
<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb bg-light rounded-3 px-3 py-2">
        <li class="breadcrumb-item">
            <a href="{{ route('home') }}" class="text-decoration-none">
                <i class="fas fa-home me-1"></i>Trang chủ
            </a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('orders.index') }}" class="text-decoration-none">Đơn hàng của tôi</a>
        </li>
        <li class="breadcrumb-item active fw-bold">#{{ $order->order_number }}</li>
    </ol>
</nav>

<!-- Page Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h1 class="h3 mb-2 fw-bold text-primary">
                    <i class="fas fa-receipt me-3"></i>
                    Chi tiết đơn hàng #{{ $order->order_number }}
                </h1>
                <p class="text-muted mb-0">Thông tin chi tiết và vé điện tử của đơn hàng</p>
            </div>
            <div>
                @if($order->status === 'paid')
                    <span class="badge bg-success bg-gradient fs-6 px-3 py-2">
                        <i class="fas fa-check-circle me-1"></i>Đã thanh toán
                    </span>
                @elseif($order->status === 'pending')
                    <span class="badge bg-warning bg-gradient fs-6 px-3 py-2">
                        <i class="fas fa-clock me-1"></i>Chờ thanh toán
                    </span>
                @else
                    <span class="badge bg-danger bg-gradient fs-6 px-3 py-2">
                        <i class="fas fa-times-circle me-1"></i>Đã hủy
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-lg order-detail-card">
            <div class="card-header bg-gradient-primary text-white border-0">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="mb-1 fw-bold">
                            <i class="fas fa-receipt me-2"></i>
                            Đơn hàng #{{ $order->order_number }}
                        </h4>
                        <small class="opacity-75">
                            <i class="fas fa-calendar-alt me-1"></i>
                            Ngày đặt: {{ $order->created_at->format('d/m/Y H:i') }}
                        </small>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <div class="d-flex align-items-center justify-content-md-end">
                            <div class="text-end">
                                <h5 class="mb-0 text-white">{{ number_format($order->total_amount) }}đ</h5>
                                <small class="opacity-75">Tổng giá trị</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <!-- Order Info -->
                <div class="row mb-5">
                    <div class="col-md-6">
                        <div class="info-card p-4 bg-light rounded-3">
                            <h6 class="mb-3 fw-bold text-primary">
                                <i class="fas fa-user me-2"></i>Thông tin khách hàng
                            </h6>
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-id-card me-2 text-primary"></i>
                                        <span class="fw-medium">Tên:</span>
                                        <span class="ms-2">{{ $order->user->name }}</span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-envelope me-2 text-primary"></i>
                                        <span class="fw-medium">Email:</span>
                                        <span class="ms-2">{{ $order->user->email }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-card p-4 bg-light rounded-3">
                            <h6 class="mb-3 fw-bold text-primary">
                                <i class="fas fa-credit-card me-2"></i>Thông tin thanh toán
                            </h6>
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-payment me-2 text-primary"></i>
                                        <span class="fw-medium">Phương thức:</span>
                                        <span class="ms-2">{{ ucfirst($order->payment_method) }}</span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-receipt me-2 text-primary"></i>
                                        <span class="fw-medium">Mã giao dịch:</span>
                                        <span class="ms-2 text-muted">{{ $order->payment_reference }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tickets -->
                <div class="mb-4">
                    <h5 class="mb-3 fw-bold text-primary">
                        <i class="fas fa-ticket-alt me-2"></i>
                        Vé điện tử
                    </h5>
                </div>
                
                <div class="row">
                    @foreach($order->tickets->groupBy('event_id') as $eventId => $tickets)
                        @php
                            $event = $tickets->first()->event;
                            $visitDate = $tickets->first()->visit_date;
                        @endphp
                        <div class="col-12 mb-4">
                            <div class="card border-0 shadow-sm ticket-card">
                                <div class="card-header bg-gradient-primary text-white border-0">
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <h5 class="mb-1 fw-bold">
                                                <i class="fas fa-calendar-alt me-2"></i>
                                                {{ $event->name }}
                                            </h5>
                                            <small class="opacity-75">
                                                <i class="fas fa-calendar-day me-1"></i>
                                                Ngày đi: {{ \Carbon\Carbon::parse($visitDate)->format('d/m/Y') }}
                                            </small>
                                        </div>
                                        <div class="col-md-4 text-md-end">
                                            <div class="d-flex align-items-center justify-content-md-end">
                                                <div class="text-end">
                                                    <h6 class="mb-0 text-white">{{ $tickets->count() }} vé</h6>
                                                    <small class="opacity-75">Tổng số vé</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-4">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="position-relative">
                                                @if($event->image)
                                                <img src="{{ asset($event->image) }}" 
                                                     class="img-fluid rounded-3 shadow-sm" 
                                                     style="height: 140px; object-fit: cover; width: 100%;"
                                                     alt="{{ $event->name }}"
                                                     onerror="this.src='https://via.placeholder.com/200x140?text=No+Image'">
                                                @else
                                                <img src="https://via.placeholder.com/200x140?text=No+Image" 
                                                     class="img-fluid rounded-3 shadow-sm" 
                                                     style="height: 140px; object-fit: cover; width: 100%;"
                                                     alt="{{ $event->name }}">
                                                @endif
                                                <div class="position-absolute top-0 end-0 m-2">
                                                    <span class="badge bg-primary bg-gradient">
                                                        {{ $tickets->count() }} vé
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="row">
                                                @foreach($tickets as $ticket)
                                                    <div class="col-md-6 mb-3">
                                                        <div class="ticket-item border rounded-3 p-3 bg-light">
                                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                                <div>
                                                                    <h6 class="mb-1 fw-bold">
                                                                        @if($ticket->type === 'adult')
                                                                            <i class="fas fa-user me-1 text-primary"></i>Vé người lớn
                                                                        @else
                                                                            <i class="fas fa-child me-1 text-success"></i>Vé trẻ em
                                                                        @endif
                                                                    </h6>
                                                                    <p class="text-muted small mb-1">
                                                                        <strong>Giá:</strong> {{ number_format($ticket->price) }}đ
                                                                    </p>
                                                                </div>
                                                                <div class="text-end">
                                                                    @if($ticket->status === 'paid')
                                                                        <span class="badge bg-success bg-gradient">Đã thanh toán</span>
                                                                    @elseif($ticket->status === 'used')
                                                                        <span class="badge bg-info bg-gradient">Đã sử dụng</span>
                                                                    @else
                                                                        <span class="badge bg-warning bg-gradient">Chờ thanh toán</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            
                                                            <!-- QR Code -->
                                                            <div class="text-center mb-3">
                                                                <div class="qr-code-container border-2 border-primary rounded-3 p-3 bg-white">
                                                                    <i class="fas fa-qrcode fa-3x text-primary mb-2"></i>
                                                                    <p class="small mb-0 fw-bold text-primary">{{ $ticket->qr_code }}</p>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="text-center">
                                                                <small class="text-muted">
                                                                    <i class="fas fa-barcode me-1"></i>
                                                                    Mã vé: {{ $ticket->qr_code }}
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Order Summary -->
                <div class="row mt-5">
                    <div class="col-md-8">
                        <div class="info-card p-4 bg-light rounded-3">
                            <h6 class="mb-3 fw-bold text-primary">
                                <i class="fas fa-info-circle me-2"></i>Lưu ý quan trọng
                            </h6>
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <div class="d-flex align-items-start">
                                        <i class="fas fa-qrcode me-2 text-primary mt-1"></i>
                                        <span class="small">Vui lòng mang theo vé điện tử (QR Code) khi đến sự kiện</span>
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="d-flex align-items-start">
                                        <i class="fas fa-calendar-check me-2 text-primary mt-1"></i>
                                        <span class="small">Vé chỉ có hiệu lực trong ngày đã chọn</span>
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="d-flex align-items-start">
                                        <i class="fas fa-ban me-2 text-primary mt-1"></i>
                                        <span class="small">Không được hoàn tiền sau khi thanh toán</span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex align-items-start">
                                        <i class="fas fa-phone me-2 text-primary mt-1"></i>
                                        <span class="small">Liên hệ hotline 1900 1234 nếu có thắc mắc</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm bg-gradient-light">
                            <div class="card-body p-4">
                                <h6 class="card-title fw-bold text-primary mb-3">
                                    <i class="fas fa-calculator me-2"></i>Tổng kết đơn hàng
                                </h6>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="small">Tạm tính:</span>
                                    <span class="small">{{ number_format($order->total_amount / 1.1) }}đ</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="small">Thuế VAT (10%):</span>
                                    <span class="small">{{ number_format($order->total_amount * 0.1) }}đ</span>
                                </div>
                                <hr class="my-3">
                                <div class="d-flex justify-content-between">
                                    <strong>Tổng cộng:</strong>
                                    <strong class="text-success fs-5">{{ number_format($order->total_amount) }}đ</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-light border-0 p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left me-2"></i>Quay lại danh sách
                    </a>
                    @if($order->status === 'paid')
                        <button class="btn btn-success btn-sm" onclick="downloadTickets({{ $order->id }})">
                            <i class="fas fa-download me-2"></i>Tải vé điện tử
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Order Detail Page Custom Styles */
    .order-detail-card {
        transition: all var(--transition-normal);
        border: 1px solid var(--gray-200);
    }
    
    .order-detail-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-xl) !important;
    }
    
    .bg-gradient-primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark)) !important;
    }
    
    .bg-gradient-light {
        background: linear-gradient(135deg, var(--gray-50), var(--gray-100)) !important;
    }
    
    .info-card {
        transition: all var(--transition-normal);
        border: 1px solid var(--gray-200);
    }
    
    .info-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }
    
    .ticket-card {
        transition: all var(--transition-normal);
        border: 1px solid var(--gray-200);
    }
    
    .ticket-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
    }
    
    .ticket-item {
        transition: all var(--transition-normal);
        border: 1px solid var(--gray-200);
    }
    
    .ticket-item:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        border-color: var(--primary);
    }
    
    .qr-code-container {
        transition: all var(--transition-normal);
        border: 2px solid var(--primary) !important;
    }
    
    .qr-code-container:hover {
        transform: scale(1.05);
        box-shadow: var(--shadow-md);
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
    
    .card-footer {
        border-radius: 0 0 var(--radius-xl) var(--radius-xl) !important;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .order-detail-card .col-md-4 {
            margin-top: var(--spacing-lg);
        }
        
        .ticket-item {
            margin-bottom: var(--spacing-md);
        }
        
        .qr-code-container {
            padding: var(--spacing-sm) !important;
        }
        
        .qr-code-container i {
            font-size: 2rem !important;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    function downloadTickets(orderId) {
        // Simulate ticket download
        alert('Tính năng tải vé sẽ được triển khai trong phiên bản tiếp theo!');
    }
    
    // Add loading state to buttons
    document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('.btn');
        buttons.forEach(button => {
            button.addEventListener('click', function() {
                if (this.classList.contains('btn-primary') || this.classList.contains('btn-success')) {
                    const originalText = this.innerHTML;
                    this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Đang xử lý...';
                    this.disabled = true;
                    
                    setTimeout(() => {
                        this.innerHTML = originalText;
                        this.disabled = false;
                    }, 2000);
                }
            });
        });
        
        // Add animation to QR codes
        const qrCodes = document.querySelectorAll('.qr-code-container');
        qrCodes.forEach(qr => {
            qr.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.05)';
            });
            
            qr.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
            });
        });
    });
</script>
@endsection
