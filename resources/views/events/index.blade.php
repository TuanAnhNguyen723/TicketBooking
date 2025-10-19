@extends('layouts.app')

@section('title', 'Trang chủ - Khu Vui Chơi & Sự Kiện')

@section('content')
<!-- Events Section -->
<section id="events" class="py-5">
    <div class="container">
        <!-- Địa điểm du lịch Section -->
        @if($attractions->count() > 0)
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="display-5 fw-bold mb-3">
                    <i class="fas fa-map-marked-alt me-3 text-success"></i>
                    Địa điểm du lịch nổi bật
                </h2>
                <p class="lead text-muted">Khám phá những điểm đến hấp dẫn và thú vị</p>
            </div>
        </div>

        <div class="row g-4 mb-5">
            @foreach($attractions as $event)
                <div class="col-lg-4 col-md-6">
                    <div class="card event-card h-100 border-0 shadow-sm">
                        <div class="position-relative overflow-hidden">
                            @if($event->image)
                            @php
                                $homeImagePath = $event->image;
                                if (!str_starts_with($homeImagePath, 'images/events/')) {
                                    $homeImagePath = 'images/events/' . $homeImagePath;
                                }
                            @endphp
                            <img src="{{ asset($homeImagePath) }}" 
                                 class="card-img-top event-image" 
                                 alt="{{ $event->name }}"
                                 onerror="this.style.display='none';">
                            @endif
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
                            <div class="position-absolute top-0 start-0 m-3">
                                <span class="badge bg-danger bg-gradient px-3 py-2">
                                    Còn lại: {{ $remainingTotal }}
                                </span>
                            </div>
                            @endif
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge bg-info bg-gradient px-3 py-2">
                                    <i class="fas fa-map-marker-alt me-1"></i>
                                    {{ $event->category_name }}
                                </span>
                            </div>
                            <div class="position-absolute bottom-0 start-0 m-3">
                                <span class="price-tag">
                                    Từ {{ number_format($event->child_price) }}₫
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
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($event->opening_time)->format('H:i') }} - 
                                        {{ \Carbon\Carbon::parse($event->closing_time)->format('H:i') }}
                                    </small>
                                </div>
                            </div>
                            
                            <div class="mt-auto">
                                <a href="{{ route('events.show', $event) }}" class="btn btn-success w-100">
                                    <i class="fas fa-eye me-2"></i>Xem chi tiết
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @endif

        <!-- Sự kiện & Lễ hội Section -->
        @if($featuredEvents->count() > 0)
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="display-5 fw-bold mb-3">
                    <i class="fas fa-calendar-alt me-3 text-primary"></i>
                    Sự kiện & Lễ hội nổi bật
                </h2>
                <p class="lead text-muted">Khám phá những sự kiện và lễ hội đặc sắc đang diễn ra</p>
            </div>
        </div>

        <div class="row g-4 mb-5">
            @foreach($featuredEvents as $event)
                <div class="col-lg-4 col-md-6">
                    <div class="card event-card h-100 border-0 shadow-sm">
                        <div class="position-relative overflow-hidden">
                            @if($event->image)
                            @php
                                $homeImagePath = $event->image;
                                if (!str_starts_with($homeImagePath, 'images/events/')) {
                                    $homeImagePath = 'images/events/' . $homeImagePath;
                                }
                            @endphp
                            <img src="{{ asset($homeImagePath) }}" 
                                 class="card-img-top event-image" 
                                 alt="{{ $event->name }}"
                                 onerror="this.style.display='none';">
                            @endif
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
                            <div class="position-absolute top-0 start-0 m-3">
                                <span class="badge bg-danger bg-gradient px-3 py-2">
                                    Còn lại: {{ $remainingTotal }}
                                </span>
                            </div>
                            @endif
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge bg-success bg-gradient px-3 py-2">
                                    <i class="fas fa-calendar me-1"></i>
                                    {{ $event->category_name }}
                                </span>
                            </div>
                            <div class="position-absolute bottom-0 start-0 m-3">
                                <span class="price-tag">
                                    Từ {{ number_format($event->child_price) }}₫
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
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($event->opening_time)->format('H:i') }} - 
                                        {{ \Carbon\Carbon::parse($event->closing_time)->format('H:i') }}
                                    </small>
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
        @endif

        <!-- Empty state nếu không có sự kiện nào -->
        @if($featuredEvents->count() == 0 && $attractions->count() == 0)
        <div class="row">
            <div class="col-12">
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
        @endif
    </div>
</section>
@endsection