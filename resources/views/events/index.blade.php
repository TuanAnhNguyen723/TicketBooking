@extends('layouts.app')

@section('title', 'Trang chủ - Khu Vui Chơi & Sự Kiện')

@section('content')
<!-- Events Section -->
<section id="events" class="py-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="display-5 fw-bold mb-3">
                    <i class="fas fa-star me-3 text-warning"></i>
                    Sự kiện & Khu vui chơi nổi bật
                </h2>
                @if(isset($query))
                    <p class="lead text-muted">
                        Kết quả tìm kiếm cho: <span class="badge bg-primary fs-6">{{ $query }}</span>
                    </p>
                @else
                    <p class="lead text-muted">Khám phá những trải nghiệm tuyệt vời đang chờ đón bạn</p>
                @endif
            </div>
        </div>

@if($events->count() > 0)
    <div class="row g-4">
        @foreach($events as $event)
            <div class="col-lg-4 col-md-6">
                <div class="card event-card h-100 border-0 shadow-sm">
                    <div class="position-relative overflow-hidden">
                        <img src="{{ asset('images/events/' . $event->image) }}" 
                             class="card-img-top event-image" 
                             alt="{{ $event->name }}"
                             onerror="this.src='https://via.placeholder.com/400x220?text=No+Image'">
                        <div class="position-absolute top-0 end-0 m-3">
                            <span class="badge bg-success">
                                <i class="fas fa-calendar-check me-1"></i>
                                {{ \Carbon\Carbon::parse($event->start_date)->format('d/m') }}
                            </span>
                        </div>
                        <div class="position-absolute bottom-0 start-0 m-3">
                            <span class="price-tag">
                                Từ {{ number_format($event->child_price) }}đ
                            </span>
                        </div>
                    </div>
                    
                    <div class="card-body d-flex flex-column p-4">
                        <div class="mb-3">
                            <h5 class="card-title fw-bold mb-2">{{ $event->name }}</h5>
                            <p class="card-text text-muted small flex-grow-1 mb-3">
                                {{ Str::limit($event->short_description, 120) }}
                            </p>
                        </div>
                        
                        <div class="mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                <span class="location-tag">{{ $event->location }}</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-clock text-primary me-2"></i>
                                <small class="text-muted">{{ $event->opening_time }} - {{ $event->closing_time }}</small>
                            </div>
                        </div>
                        
                        <div class="mt-auto">
                            <a href="{{ route('events.show', $event) }}" class="btn btn-primary w-100">
                                <i class="fas fa-eye me-2"></i>Xem chi tiết
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    <!-- Pagination -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="d-flex justify-content-center">
                {{ $events->links() }}
            </div>
        </div>
    </div>
@else
    <div class="row">
        <div class="col-12">
            <div class="text-center py-5">
                <div class="empty-state">
                    <i class="fas fa-search fa-4x text-muted mb-4"></i>
                    <h3 class="text-muted mb-3">Không có kết quả phù hợp</h3>
                    <p class="text-muted mb-4">
                        @if(isset($query))
                            Không tìm thấy sự kiện nào với từ khóa "{{ $query }}"
                        @else
                            Hiện tại chưa có sự kiện nào
                        @endif
                    </p>
                    <a href="{{ route('home') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-home me-2"></i>Về trang chủ
                    </a>
                </div>
            </div>
        </div>
    </div>
@endif
    </div>
</section>
@endsection
