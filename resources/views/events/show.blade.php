@extends('layouts.app')

@section('title', $event->name . ' - Chi tiết sự kiện')

@push('styles')
<style>
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.weather-info {
    transition: all 0.3s ease;
}

.weather-info.show {
    animation: fadeIn 0.5s ease-in;
}
</style>
@endpush

@section('content')
<!-- Page Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb" class="mb-3">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}" class="text-decoration-none">
                                <i class="fas fa-home me-1"></i>Trang chủ
                            </a>
                        </li>
                        <li class="breadcrumb-item active">{{ $event->name }}</li>
                    </ol>
                </nav>
                
                <h1 class="h3 mb-2 fw-bold text-primary">
                    <i class="fas fa-calendar-alt me-3"></i>
                    {{ $event->name }}
                </h1>
                <p class="text-muted mb-0">
                    <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                    {{ $event->location }}
                </p>
                @if($event->category == 'event' && $event->status_name)
                <div class="mt-2">
                    <span class="badge bg-{{ $event->status_color }} bg-gradient px-3 py-2 fs-6">
                        <i class="fas {{ $event->status == 'upcoming' ? 'fa-clock' : ($event->status == 'ongoing' ? 'fa-play' : 'fa-stop') }} me-1"></i>
                        {{ $event->status_name }}
                    </span>
                </div>
                @endif
            </div>
            <div>
                <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Quay lại
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Event Images -->
    <div class="col-lg-8">
        <div class="card mb-4 border-0 shadow-sm event-gallery-card">
            <div class="card-header bg-gradient-primary text-white border-0">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-images me-2"></i>
                    Hình ảnh sự kiện
                </h5>
            </div>
            <div class="card-body p-0">
                @if($event->image || ($event->gallery && is_array($event->gallery) && count($event->gallery) > 0))
                <!-- Hiển thị carousel khi có ảnh -->
                <div id="eventCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="position-relative">
                                @if($event->image)
                                @php
                                    $imagePath = $event->image;
                                    if (!str_starts_with($imagePath, 'images/events/')) {
                                        $imagePath = 'images/events/' . $imagePath;
                                    }
                                @endphp
                                <img src="{{ asset($imagePath) }}" 
                                     class="d-block w-100 event-main-image" 
                                     alt="{{ $event->name }}"
                                     onerror="this.style.display='none';">
                                @endif
                                <div class="position-absolute top-0 end-0 m-3">
                                    <span class="badge bg-primary bg-gradient fs-6 px-3 py-2">
                                        <i class="fas fa-camera me-1"></i>Hình chính
                                    </span>
                                </div>
                            </div>
                        </div>
                        @if($event->gallery && is_array($event->gallery) && count($event->gallery) > 0)
                            @foreach($event->gallery as $index => $image)
                                @if($image && !empty($image))
                                @php
                                    $galleryImagePath = $image;
                                    if (!str_starts_with($galleryImagePath, 'images/events/')) {
                                        $galleryImagePath = 'images/events/' . $galleryImagePath;
                                    }
                                @endphp
                                <div class="carousel-item">
                                    <div class="position-relative">
                                        <img src="{{ asset($galleryImagePath) }}" 
                                             class="d-block w-100 event-main-image" 
                                             alt="{{ $event->name }}"
                                             onerror="this.style.display='none';">
                                        <div class="position-absolute top-0 end-0 m-3">
                                            <span class="badge bg-success bg-gradient fs-6 px-3 py-2">
                                                <i class="fas fa-image me-1"></i>{{ $index + 2 }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                @endif
                @if($event->gallery && is_array($event->gallery) && count($event->gallery) > 0)
                <button class="carousel-control-prev custom-carousel-control" type="button" data-bs-target="#eventCarousel" data-bs-slide="prev">
                    <span class="bg-primary text-white rounded-circle hover-scale d-flex align-items-center justify-content-center">
                        <i class="fas fa-chevron-left fs-4"></i>
                    </span>
                </button>
                <button class="carousel-control-next custom-carousel-control" type="button" data-bs-target="#eventCarousel" data-bs-slide="next">
                    <span class="bg-primary text-white rounded-circle hover-scale d-flex align-items-center justify-content-center">
                        <i class="fas fa-chevron-right fs-4"></i>
                    </span>
                </button>
                @endif

    <style>
        .custom-carousel-control {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 50px;
            height: 50px;
            z-index: 10;
        }
        
        .custom-carousel-control .hover-scale {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: rgba(13, 110, 253, 0.9) !important;
            border: 2px solid white;
            transition: all 0.3s ease;
            opacity: 0.8;
        }
        
        .custom-carousel-control:hover .hover-scale {
            transform: scale(1.15);
            background-color: rgba(13, 110, 253, 1) !important;
            opacity: 1;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }
        
        .custom-carousel-control .fas {
            font-weight: 900;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
        }
        
        .carousel-control-prev {
            left: 15px;
        }
        
        .carousel-control-next {
            right: 15px;
        }
        
        /* Đảm bảo nút được căn giữa hoàn hảo */
        .custom-carousel-control .hover-scale {
            position: relative;
            top: 0;
            left: 0;
            transform: none;
        }
    </style>
                </div>
                
                <!-- Thumbnail Gallery - chỉ hiển thị khi có ảnh -->
                @if($event->image || ($event->gallery && is_array($event->gallery) && count($event->gallery) > 0))
                <div class="p-3">
                    <div class="row g-2">
                        <div class="col-3">
                            <div class="thumbnail-item active" data-bs-target="#eventCarousel" data-bs-slide-to="0">
                                @if($event->image)
                                @php
                                    $thumbnailImagePath = $event->image;
                                    if (!str_starts_with($thumbnailImagePath, 'images/events/')) {
                                        $thumbnailImagePath = 'images/events/' . $thumbnailImagePath;
                                    }
                                @endphp
                                <img src="{{ asset($thumbnailImagePath) }}" 
                                     class="img-fluid rounded thumbnail-img" 
                                     alt="Thumbnail 1"
                                     onerror="this.style.display='none';">
                                @else
                                <div class="img-fluid rounded thumbnail-img bg-gray-200 d-flex align-items-center justify-content-center">
                                    <i class="fas fa-image text-gray-400"></i>
                                </div>
                                @endif
                            </div>
                        </div>
                        @if($event->gallery && is_array($event->gallery) && count($event->gallery) > 0)
                            @foreach($event->gallery as $index => $image)
                                @if($image && !empty($image))
                                <div class="col-3">
                                    <div class="thumbnail-item" data-bs-target="#eventCarousel" data-bs-slide-to="{{ $index + 1 }}">
                                        @php
                                            $galleryThumbnailPath = $image;
                                            if (!str_starts_with($galleryThumbnailPath, 'images/events/')) {
                                                $galleryThumbnailPath = 'images/events/' . $galleryThumbnailPath;
                                            }
                                        @endphp
                                        <img src="{{ asset($galleryThumbnailPath) }}" 
                                             class="img-fluid rounded thumbnail-img" 
                                             alt="Thumbnail {{ $index + 2 }}"
                                             onerror="this.style.display='none';">
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Event Description -->
        <div class="card mb-4 border-0 shadow-sm event-info-card">
            <div class="card-header bg-gradient-primary text-white border-0">
                <h4 class="mb-0 fw-bold">
                    <i class="fas fa-info-circle me-2"></i>
                    Thông tin chi tiết
                </h4>
            </div>
            <div class="card-body p-4">
                <div class="event-description">
                    <p class="card-text fs-6 lh-lg">{{ $event->description }}</p>
                </div>
                
                <!-- Event Highlights -->
                <div class="row mt-4">
                    @if($event->category == 'event')
                    <div class="col-md-6 mb-3">
                        <div class="info-highlight">
                            <div class="d-flex align-items-center">
                                <div class="highlight-icon me-3">
                                    <i class="fas fa-calendar-alt text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold">Thời gian diễn ra</h6>
                                    <p class="mb-0 text-muted">
                                        {{ \Carbon\Carbon::parse($event->start_date)->format('d/m/Y') }} - 
                                        {{ \Carbon\Carbon::parse($event->end_date)->format('d/m/Y') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="col-md-6 mb-3">
                        <div class="info-highlight">
                            <div class="d-flex align-items-center">
                                <div class="highlight-icon me-3">
                                    <i class="fas fa-clock text-success"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold">Giờ mở cửa</h6>
                                    <p class="mb-0 text-muted">
                                        {{ \Carbon\Carbon::parse($event->opening_time)->format('H:i') }} - 
                                        {{ \Carbon\Carbon::parse($event->closing_time)->format('H:i') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="info-highlight">
                            <div class="d-flex align-items-center">
                                <div class="highlight-icon me-3">
                                    <i class="fas fa-map-marker-alt text-danger"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold">Địa điểm</h6>
                                    <p class="mb-0 text-muted">{{ $event->location }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="info-highlight">
                            <div class="d-flex align-items-center">
                                <div class="highlight-icon me-3">
                                    <i class="fas fa-star text-warning"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold">Đánh giá trung bình</h6>
                                    <p class="mb-0 text-muted">
                                        @if($event->average_rating > 0)
                                            {{ number_format($event->average_rating, 1) }}/5.0 
                                            <span class="text-warning">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $event->average_rating)
                                                        <i class="fas fa-star"></i>
                                                    @elseif($i - 0.5 <= $event->average_rating)
                                                        <i class="fas fa-star-half-alt"></i>
                                                    @else
                                                        <i class="far fa-star"></i>
                                                    @endif
                                                @endfor
                                            </span>
                                        @else
                                            Chưa có đánh giá
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        @auth
        <!-- Write Review -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-gradient-primary text-white border-0">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-pen-alt me-2"></i>
                    Viết đánh giá của bạn
                </h5>
            </div>
            <div class="card-body p-4">
                @if(session('error'))
                    <div class="alert alert-warning">{{ session('error') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger mb-3">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="POST" action="{{ route('reviews.store') }}" id="reviewForm">
                    @csrf
                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                    <div class="mb-3">
                        <div class="text-warning fs-4" id="ratingStars">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="far fa-star rating-star" data-value="{{ $i }}" style="cursor: pointer;"></i>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" id="ratingInput" value="5">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Nhận xét (tuỳ chọn)</label>
                        <textarea name="comment" rows="3" class="form-control" placeholder="Chia sẻ trải nghiệm của bạn..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-2"></i>Gửi đánh giá
                    </button>
                </form>
            </div>
        </div>
        @endauth

        <!-- Reviews -->
        @if($reviews->count() > 0)
            <div class="card border-0 shadow-sm reviews-card">
                <div class="card-header bg-gradient-primary text-white border-0">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-star me-2"></i>
                        Đánh giá từ khách hàng ({{ $reviews->count() }})
                    </h5>
                </div>
                <div class="card-body p-4">
                    @foreach($reviews as $review)
                        <div class="review-item mb-4 pb-4 border-bottom border-light">
                            <div class="d-flex align-items-start">
                                <div class="review-avatar me-3">
                                    <div class="avatar-circle">
                                        <i class="fas fa-user"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h6 class="mb-1 fw-bold">{{ $review->user->name }}</h6>
                                            <div class="text-warning mb-2">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $review->rating)
                                                        <i class="fas fa-star"></i>
                                                    @else
                                                        <i class="far fa-star"></i>
                                                    @endif
                                                @endfor
                                                <span class="ms-2 text-muted small">{{ $review->rating }}/5</span>
                                            </div>
                                        </div>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar-alt me-1"></i>
                                            {{ $review->created_at->format('d/m/Y') }}
                                        </small>
                                    </div>
                                    @if($review->comment)
                                        <div class="review-comment">
                                            <p class="mb-0 lh-lg">{{ $review->comment }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="card border-0 shadow-sm">
                <div class="card-body p-5 text-center">
                    <div class="empty-reviews">
                        <i class="fas fa-star fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted mb-2">Chưa có đánh giá nào</h5>
                        <p class="text-muted mb-0">Hãy là người đầu tiên đánh giá sự kiện này!</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
    
    <!-- Booking Sidebar -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-lg sticky-top booking-card" style="top: 2rem;">
            <div class="card-header bg-gradient-primary text-white border-0">
                <h4 class="mb-0 fw-bold">
                    <i class="fas fa-ticket-alt me-2"></i>
                    Đặt vé ngay
                </h4>
            </div>
            <div class="card-body p-4">
                <!-- Pricing -->
                <div class="pricing-section mb-4">
                    <h5 class="text-primary mb-3 fw-bold">
                        <i class="fas fa-tags me-2"></i>Giá vé
                    </h5>
                    <div class="price-item mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-user me-2 text-primary"></i>
                                <span class="fw-medium">Người lớn</span>
                            </div>
                            <strong class="text-success fs-5">{{ number_format($event->adult_price) }}đ</strong>
                        </div>
                    </div>
                    <div class="price-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-child me-2 text-success"></i>
                                <span class="fw-medium">Trẻ em</span>
                            </div>
                            <strong class="text-success fs-5">{{ number_format($event->child_price) }}đ</strong>
                        </div>
                    </div>
                </div>
                
                <!-- Event Info Summary -->
                <div class="event-summary mb-4">
                    @if($event->category == 'event')
                    <div class="summary-item mb-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-calendar-alt me-2 text-primary"></i>
                            <div>
                                <small class="text-muted">Thời gian</small>
                                <p class="mb-0 fw-medium">
                                    {{ \Carbon\Carbon::parse($event->start_date)->format('d/m/Y') }} - 
                                    {{ \Carbon\Carbon::parse($event->end_date)->format('d/m/Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="summary-item mb-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-clock me-2 text-success"></i>
                            <div>
                                <small class="text-muted">Giờ mở cửa</small>
                                <p class="mb-0 fw-medium">
                                    {{ \Carbon\Carbon::parse($event->opening_time)->format('H:i') }} - 
                                    {{ \Carbon\Carbon::parse($event->closing_time)->format('H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="summary-item">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-map-marker-alt me-2 text-danger"></i>
                            <div>
                                <small class="text-muted">Địa điểm</small>
                                <p class="mb-0 fw-medium">{{ $event->location }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Booking Form -->
                <form action="{{ route('booking.add-to-cart', $event) }}" method="POST" id="bookingForm">
                    @csrf
                    
                    <div class="booking-form">
                        <div class="mb-3">
                            <label class="form-label fw-medium">
                                <i class="fas fa-calendar-check me-2 text-primary"></i>Ngày đi
                            </label>
                            <input type="date" 
                                   class="form-control" 
                                   name="visit_date" 
                                   id="visit_date"
                                   min="{{ max($event->start_date, now()->toDateString()) }}"
                                   max="{{ $event->end_date }}"
                                   required>
                            <div class="form-text" id="availability_help"></div>
                        </div>
                        
                        <!-- Weather Information -->
                        <div id="weather-info" class="mb-3 weather-info" style="display: none;">
                            <div class="alert alert-info d-flex align-items-center" role="alert">
                                <div class="me-3">
                                    <i class="fas fa-cloud-sun fa-2x text-info"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="alert-heading mb-1">
                                        <span id="weather-date"></span>
                                    </h6>
                                    <div class="d-flex align-items-center mb-2">
                                        <span id="weather-temp" class="fw-bold me-3"></span>
                                        <span id="weather-desc" class="text-muted"></span>
                                    </div>
                                    <div id="weather-advice" class="small"></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-6">
                                <label class="form-label fw-medium">
                                    <i class="fas fa-user me-1 text-primary"></i>Người lớn
                                </label>
                                <select class="form-select" name="adult_quantity" id="adult_quantity">
                                    <option value="0">0</option>
                                    @for($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-medium">
                                    <i class="fas fa-child me-1 text-success"></i>Trẻ em
                                </label>
                                <select class="form-select" name="child_quantity" id="child_quantity">
                                    <option value="0">0</option>
                                    @for($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        
                        <!-- Total Price Display -->
                        <div class="total-price-display mb-3 p-3 bg-light rounded-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold">Tổng tiền:</span>
                                <span class="text-success fs-4 fw-bold" id="total_price">0đ</span>
                            </div>
                        </div>

                        @php
                            $remainingTotal = null;
                            if (!is_null($event->total_capacity)) {
                                $sold = \App\Models\Ticket::where('event_id', $event->id)
                                    ->whereIn('status', ['paid','checked_in'])
                                    ->count();
                                $remainingTotal = max(0, $event->total_capacity - $sold);
                            }
                        @endphp
                        @if(!is_null($event->total_capacity))
                        <div class="alert alert-info d-flex align-items-center" role="alert">
                            <i class="fas fa-info-circle me-2"></i>
                            <div>
                                Số vé còn lại: <strong>{{ $remainingTotal }}</strong>
                            </div>
                        </div>
                        @endif
                        
                        <button type="submit" class="btn btn-primary btn-lg w-100 mb-3 booking-btn">
                            <i class="fas fa-shopping-cart me-2"></i>Thêm vào giỏ hàng
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Event Detail Page Custom Styles */
    .event-gallery-card, .event-info-card, .reviews-card, .booking-card {
        transition: all var(--transition-normal);
        border: 1px solid var(--gray-200);
    }
    
    .event-gallery-card:hover, .event-info-card:hover, .reviews-card:hover, .booking-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-xl) !important;
    }
    
    .bg-gradient-primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark)) !important;
    }
    
    .event-main-image {
        height: 500px;
        object-fit: cover;
        width: 100%;
    }
    
    .thumbnail-item {
        cursor: pointer;
        transition: all var(--transition-normal);
        border-radius: var(--radius-md);
        overflow: hidden;
    }
    
    .thumbnail-item:hover {
        transform: scale(1.05);
        box-shadow: var(--shadow-md);
    }
    
    .thumbnail-item.active {
        border: 2px solid var(--primary);
        box-shadow: var(--shadow-md);
    }
    
    .thumbnail-img {
        height: 80px;
        object-fit: cover;
        width: 100%;
    }
    
    .custom-carousel-control {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 50px;
        height: 50px;
        background: rgba(0, 0, 0, 0.5);
        border: none;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all var(--transition-normal);
        opacity: 0.7;
        z-index: 10;
    }
    
    .custom-carousel-control:hover {
        background: var(--bg-secondary);
        opacity: 1;
        transform: translateY(-50%) scale(1.1);
    }
    
    .custom-carousel-control:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.5);
    }
    
    .custom-carousel-control .carousel-control-prev-icon,
    .custom-carousel-control .carousel-control-next-icon {
        width: 16px;
        height: 16px;
        border-radius: 2px;
        opacity: 1;
    }
    
    .custom-carousel-control .carousel-control-prev-icon {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23000000'%3e%3cpath d='M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z'/%3e%3c/svg%3e");
    }
    
    .custom-carousel-control .carousel-control-next-icon {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23000000'%3e%3cpath d='M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
    }
    
    .carousel-control-prev {
        left: 15px;
    }
    
    .carousel-control-next {
        right: 15px;
    }
    
    .highlight-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--primary-light);
        border-radius: var(--radius-lg);
        font-size: var(--font-size-lg);
    }
    
    .info-highlight {
        padding: var(--spacing-md);
        background: var(--bg-secondary);
        border-radius: var(--radius-lg);
        border: 1px solid var(--gray-200);
        transition: all var(--transition-normal);
    }
    
    .info-highlight:hover {
        border-color: var(--primary);
        box-shadow: var(--shadow-sm);
    }
    
    .avatar-circle {
        width: 50px;
        height: 50px;
        background: var(--primary);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: var(--font-size-lg);
    }
    
    .review-item {
        transition: all var(--transition-normal);
    }
    
    .review-item:hover {
        background: var(--bg-secondary);
        border-radius: var(--radius-lg);
        padding: var(--spacing-md);
        margin: calc(-1 * var(--spacing-md));
    }
    
    .price-item {
        padding: var(--spacing-md);
        background: var(--bg-secondary);
        border-radius: var(--radius-lg);
        border: 1px solid var(--gray-200);
        transition: all var(--transition-normal);
    }
    
    .price-item:hover {
        border-color: var(--primary);
        box-shadow: var(--shadow-sm);
    }
    
    .summary-item {
        padding: var(--spacing-md);
        background: var(--bg-secondary);
        border-radius: var(--radius-lg);
        border: 1px solid var(--gray-200);
        transition: all var(--transition-normal);
    }
    
    .summary-item:hover {
        border-color: var(--primary);
        box-shadow: var(--shadow-sm);
    }
    
    .total-price-display {
        border: 2px solid var(--success);
        background: linear-gradient(135deg, var(--accent-50), var(--accent-100)) !important;
        transition: all var(--transition-normal);
    }
    
    .total-price-display:hover {
        transform: scale(1.02);
        box-shadow: var(--shadow-md);
    }
    
    .booking-btn {
        position: relative;
        overflow: hidden;
    }
    
    .booking-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }
    
    .booking-btn:hover::before {
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
    
    .empty-reviews {
        animation: fadeInUp 0.6s ease-out;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .event-main-image {
            height: 300px;
        }
        
        .thumbnail-img {
            height: 60px;
        }
        
        .sticky-top {
            position: relative !important;
            top: auto !important;
        }
        
        .highlight-icon {
            width: 35px;
            height: 35px;
            font-size: var(--font-size-base);
        }
        
        .avatar-circle {
            width: 40px;
            height: 40px;
            font-size: var(--font-size-base);
        }
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Update total price when quantity changes
        const adultSelect = document.querySelector('#adult_quantity');
        const childSelect = document.querySelector('#child_quantity');
        const totalPriceElement = document.querySelector('#total_price');
        const adultPrice = parseFloat('{{ $event->adult_price }}');
        const childPrice = parseFloat('{{ $event->child_price }}');
        
        async function fetchAvailability() {
            const dateInput = document.querySelector('#visit_date');
            const help = document.querySelector('#availability_help');
            if (!dateInput || !help) return;
            const selected = dateInput.value;
            if (!selected) { help.textContent = ''; return; }
            try {
                const res = await fetch(`{{ route('events.availability', $event) }}?date=${selected}`);
                const data = await res.json();
                if (data.unlimited) {
                    help.textContent = 'Số lượng: không giới hạn';
                } else {
                    help.textContent = `Còn lại: ${data.remaining} vé`;
                }
            } catch { /* ignore */ }
        }

        function updateTotal() {
            const adultQty = parseInt(adultSelect.value) || 0;
            const childQty = parseInt(childSelect.value) || 0;
            const total = (adultQty * adultPrice) + (childQty * childPrice);
            
            if (total > 0) {
                totalPriceElement.textContent = new Intl.NumberFormat('vi-VN').format(total) + 'đ';
                totalPriceElement.style.color = 'var(--success)';
            } else {
                totalPriceElement.textContent = '0đ';
                totalPriceElement.style.color = 'var(--text-muted)';
            }
        }
        
        adultSelect.addEventListener('change', updateTotal);
        childSelect.addEventListener('change', updateTotal);
        document.querySelector('#visit_date').addEventListener('change', () => { fetchAvailability(); });
        
        // Initialize total price
        updateTotal();
        fetchAvailability();
        
        // Thumbnail click functionality
        const thumbnailItems = document.querySelectorAll('.thumbnail-item');
        thumbnailItems.forEach((item, index) => {
            item.addEventListener('click', function() {
                // Remove active class from all thumbnails
                thumbnailItems.forEach(thumb => thumb.classList.remove('active'));
                // Add active class to clicked thumbnail
                this.classList.add('active');
                
                // Trigger carousel slide
                const carousel = bootstrap.Carousel.getInstance(document.querySelector('#eventCarousel'));
                if (carousel) {
                    carousel.to(index);
                }
            });
        });
        
        // Add loading state to booking button
        const bookingForm = document.querySelector('#bookingForm');
        const bookingBtn = document.querySelector('.booking-btn');
        
        bookingForm.addEventListener('submit', function(e) {
            const adultQty = parseInt(adultSelect.value) || 0;
            const childQty = parseInt(childSelect.value) || 0;
            
            if (adultQty === 0 && childQty === 0) {
                e.preventDefault();
                showToast('Vui lòng chọn ít nhất 1 vé!', 'warning', 2000);
                return;
            }
            
            const originalText = bookingBtn.innerHTML;
            bookingBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Đang thêm vào giỏ hàng...';
            bookingBtn.disabled = true;
            
            // Re-enable after 3 seconds (fallback)
            setTimeout(() => {
                bookingBtn.innerHTML = originalText;
                bookingBtn.disabled = false;
            }, 3000);
        });
        
        // Weather functionality with debounce
        const visitDateInput = document.getElementById('visit_date');
        const weatherInfo = document.getElementById('weather-info');
        let weatherTimeout = null;
        
        if (visitDateInput && weatherInfo) {
            visitDateInput.addEventListener('change', function() {
                const selectedDate = this.value;
                console.log('Date selected:', selectedDate);
                
                // Clear previous timeout
                if (weatherTimeout) {
                    clearTimeout(weatherTimeout);
                }
                
                if (selectedDate) {
                    // Show loading immediately with better animation
                    weatherInfo.style.display = 'block';
                    weatherInfo.classList.add('show');
                    weatherInfo.innerHTML = `
                        <div class="alert alert-info d-flex align-items-center">
                            <div class="me-3">
                                <div class="spinner-border spinner-border-sm text-info" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="alert-heading mb-1">Đang tải thông tin thời tiết...</h6>
                                <div class="small text-muted">Vui lòng chờ trong giây lát</div>
                            </div>
                        </div>
                    `;
                    
                    // Debounce: Wait 1.5 seconds before making API call
                    weatherTimeout = setTimeout(() => {
                        fetchWeatherData(selectedDate);
                    }, 1500);
                } else {
                    weatherInfo.style.display = 'none';
                    weatherInfo.classList.remove('show');
                }
            });
        }
        
        function fetchWeatherData(selectedDate) {
            // Validate date before making API call
            const today = new Date().toISOString().split('T')[0];
            if (selectedDate < today) {
                weatherInfo.innerHTML = '<div class="alert alert-warning">Vui lòng chọn ngày từ hôm nay trở đi</div>';
                return;
            }
            
            const apiUrl = `${window.location.origin}/api/weather-forecast?date=${selectedDate}&city={{ $event->location }}`;
            console.log('API URL:', apiUrl);
            
            fetch(apiUrl, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                credentials: 'same-origin'
            })
                .then(response => {
                    console.log('Response status:', response.status);
                    
                    if (!response.ok) {
                        throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                    }
                    
                    const contentType = response.headers.get('content-type');
                    if (!contentType || !contentType.includes('application/json')) {
                        console.warn('Response is not JSON, content-type:', contentType);
                        return response.text().then(text => {
                            try {
                                return JSON.parse(text);
                            } catch (e) {
                                throw new Error('Response is not valid JSON');
                            }
                        });
                    }
                    
                    return response.json();
                })
                .then(data => {
                    console.log('Weather data:', data);
                    if (data.success) {
                        const weather = data.data;
                        const dateObj = new Date(selectedDate);
                        const formattedDate = dateObj.toLocaleDateString('vi-VN', {
                            weekday: 'long',
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        });
                        
                        weatherInfo.innerHTML = `
                            <div class="alert alert-${weather.advice.color} d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas fa-cloud-sun fa-2x"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">${formattedDate}</h6>
                                    <div class="mb-2">
                                        <span class="fw-bold me-3">${weather.temperature}°C</span>
                                        <span class="text-muted">${weather.description}</span>
                                    </div>
                                    <div class="small">${weather.advice.message}</div>
                                </div>
                            </div>
                        `;
                    } else {
                        weatherInfo.innerHTML = '<div class="alert alert-warning">Không thể lấy thông tin thời tiết</div>';
                    }
                })
                .catch(error => {
                    console.error('Weather error:', error);
                    weatherInfo.innerHTML = `
                        <div class="alert alert-danger">
                            <h6>Lỗi kết nối</h6>
                            <p class="mb-0">${error.message}</p>
                            <small class="text-muted">Vui lòng thử lại sau</small>
                        </div>
                    `;
                });
        }
        
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Rating stars interaction
        const stars = document.querySelectorAll('#ratingStars .rating-star');
        const ratingInput = document.getElementById('ratingInput');
        if (stars.length && ratingInput) {
            let current = parseInt(ratingInput.value || '5');
            const paint = (n) => {
                stars.forEach((s, i) => {
                    s.classList.toggle('fas', i < n);
                    s.classList.toggle('far', i >= n);
                });
            };
            paint(current);
            stars.forEach((star, idx) => {
                star.addEventListener('mouseenter', () => paint(idx + 1));
                star.addEventListener('mouseleave', () => paint(current));
                star.addEventListener('click', () => {
                    current = idx + 1;
                    ratingInput.value = current;
                    paint(current);
                });
            });
        }
    });
</script>
@endsection
