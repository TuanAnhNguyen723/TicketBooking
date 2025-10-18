@extends('layouts.app')

@section('title', 'Đơn hàng của tôi')

@section('content')
<!-- Page Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h1 class="h3 mb-2 fw-bold text-primary">
                    <i class="fas fa-shopping-bag me-3"></i>
                    Đơn hàng của tôi
                </h1>
                <p class="text-muted mb-0">Quản lý và theo dõi các đơn hàng của bạn</p>
            </div>
            <div>
                <a href="{{ route('home') }}" class="btn btn-outline-primary">
                    <i class="fas fa-plus me-2"></i>Đặt vé mới
                </a>
            </div>
        </div>
    </div>
</div>

@if($orders->count() > 0)
    <div class="row">
        @foreach($orders as $order)
            <div class="col-12 mb-4">
                <div class="card border-0 shadow-lg order-card">
                    <div class="card-header bg-gradient-primary text-white border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-1 fw-bold">
                                    <i class="fas fa-receipt me-2"></i>
                                    Đơn hàng #{{ $order->order_number }}
                                </h5>
                                <small class="opacity-75">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    Ngày đặt: {{ $order->created_at->format('d/m/Y H:i') }}
                                </small>
                            </div>
                            <div>
                                @if($order->status === 'paid')
                                    <span class="badge bg-success bg-gradient px-2 py-1" style="font-size:.85rem;">
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
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-8">
                                <h6 class="mb-4 fw-bold text-primary">
                                    <i class="fas fa-ticket-alt me-2"></i>Vé đã đặt
                                </h6>
                                @foreach($order->tickets->groupBy('event_id') as $eventId => $tickets)
                                    @php
                                        $event = $tickets->first()->event;
                                        $adultTickets = $tickets->where('type', 'adult')->count();
                                        $childTickets = $tickets->where('type', 'child')->count();
                                        $visitDate = $tickets->first()->visit_date;
                                    @endphp
                                    <div class="row mb-4 pb-4 border-bottom border-light">
                                        <div class="col-md-3">
                                            <div class="position-relative">
                                                @if($event->image)
                                                <img src="{{ asset($event->image) }}" 
                                                     class="img-fluid rounded-3 shadow-sm" 
                                                     style="height: 100px; object-fit: cover; width: 100%;"
                                                     alt="{{ $event->name }}"
                                                     onerror="this.style.display='none';">
                                                @else
                                                <div class="img-fluid rounded-3 shadow-sm bg-gray-200 d-flex align-items-center justify-content-center" style="height: 100px;">
                                                    <div class="text-center text-muted">
                                                        <i class="fas fa-image fa-lg mb-1"></i>
                                                        <p class="mb-0 small">Chưa có ảnh</p>
                                                    </div>
                                                </div>
                                                @endif
                                                <div class="position-absolute top-0 end-0 m-2">
                                                    <span class="badge bg-primary bg-gradient">
                                                        {{ $adultTickets + $childTickets }} vé
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <h6 class="mb-2 fw-bold text-dark">{{ $event->name }}</h6>
                                            <p class="text-muted mb-2">
                                                <i class="fas fa-calendar-alt me-2 text-primary"></i>
                                                <strong>Ngày đi:</strong> {{ \Carbon\Carbon::parse($visitDate)->format('d/m/Y') }}
                                            </p>
                                            <div class="row">
                                                @if($adultTickets > 0)
                                                    <div class="col-6">
                                                        <div class="d-flex align-items-center">
                                                            <i class="fas fa-user me-2 text-primary"></i>
                                                            <span class="small text-muted">
                                                                <strong>Người lớn:</strong> {{ $adultTickets }} vé
                                                            </span>
                                                        </div>
                                                    </div>
                                                @endif
                                                @if($childTickets > 0)
                                                    <div class="col-6">
                                                        <div class="d-flex align-items-center">
                                                            <i class="fas fa-child me-2 text-success"></i>
                                                            <span class="small text-muted">
                                                                <strong>Trẻ em:</strong> {{ $childTickets }} vé
                                                            </span>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-md-4">
                                <div class="bg-light rounded-3 p-4 h-100">
                                    <div class="text-center mb-4">
                                        <h4 class="text-success fw-bold mb-1">
                                            {{ number_format($order->total_amount) }}đ
                                        </h4>
                                        <small class="text-muted">
                                            <i class="fas fa-credit-card me-1"></i>
                                            {{ ucfirst($order->payment_method) }}
                                        </small>
                                    </div>
                                    
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('orders.show', $order) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-eye me-2"></i>Xem chi tiết
                                        </a>
                                        
                                        @if($order->status === 'paid')
                                            <button class="btn btn-success btn-sm" data-order-id="{{ $order->id }}" onclick="downloadTickets(this.dataset.orderId)">
                                                <i class="fas fa-download me-2"></i>Tải vé
                                            </button>
                                        @endif
                                        
                                        @if($order->status === 'paid')
                                            <div class="text-center mt-3">
                                                <small class="text-success">
                                                    <i class="fas fa-check-circle me-1"></i>
                                                    Đơn hàng đã được xác nhận
                                                </small>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    <!-- Pagination -->
    <div class="row">
        <div class="col-12">
            {{ $orders->links() }}
        </div>
    </div>
@else
    <div class="row">
        <div class="col-12">
            <div class="text-center py-5">
                <div class="empty-state">
                    <div class="empty-icon mb-4">
                        <i class="fas fa-shopping-bag fa-4x text-muted"></i>
                    </div>
                    <h3 class="text-muted mb-3">Chưa có đơn hàng nào</h3>
                    <p class="text-muted mb-4">Bạn chưa đặt vé nào. Hãy khám phá các sự kiện thú vị!</p>
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
    /* Order Page Custom Styles */
    .order-card {
        transition: all var(--transition-normal);
        border: 1px solid var(--gray-200);
    }
    
    .order-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-xl) !important;
    }
    
    .bg-gradient-primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark)) !important;
    }
    
    .bg-gradient {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    }
    
    .empty-state {
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
    
    .border-light {
        border-color: var(--gray-200) !important;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .order-card .col-md-4 {
            margin-top: var(--spacing-lg);
        }
        
        .empty-state {
            padding: var(--spacing-xl) var(--spacing-md);
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
    });
</script>
@endsection
