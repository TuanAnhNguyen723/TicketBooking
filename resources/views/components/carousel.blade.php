{{-- Carousel Component --}}
@props(['items', 'title', 'subtitle', 'icon', 'iconColor', 'itemType' => 'event'])

<div class="carousel-section mb-5">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h2 class="display-5 fw-bold mb-3">
                <i class="{{ $icon }} me-3 {{ $iconColor }}"></i>
                {{ $title }}
            </h2>
            <p class="lead text-muted">{{ $subtitle }}</p>
        </div>
    </div>

    @if($items->count() > 0)
    <div class="carousel-container position-relative">
        <div class="carousel-wrapper overflow-hidden">
            <div class="carousel-track d-flex" id="carousel-track-{{ $itemType }}">
                @foreach($items as $item)
                    <div class="carousel-slide flex-shrink-0" style="width: 33.333%;">
                        <div class="card event-card h-100 border-0 shadow-sm mx-2">
                            <div class="position-relative overflow-hidden">
                                @if($item->image)
                                @php
                                    $homeImagePath = $item->image;
                                    if (!str_starts_with($homeImagePath, 'images/events/')) {
                                        $homeImagePath = 'images/events/' . $homeImagePath;
                                    }
                                @endphp
                                <img src="{{ asset($homeImagePath) }}" 
                                     class="card-img-top event-image" 
                                     alt="{{ $item->name }}"
                                     onerror="this.style.display='none';">
                                @endif
                                @php
                                    $remainingTotal = null;
                                    if (!is_null($item->total_capacity)) {
                                        $sold = \App\Models\Ticket::where('event_id', $item->id)
                                            ->whereIn('status', ['paid','checked_in'])
                                            ->count();
                                        $remainingTotal = max(0, $item->total_capacity - $sold);
                                    }
                                @endphp
                                @if(!is_null($item->total_capacity))
                                <div class="position-absolute top-0 start-0 m-3">
                                    <span class="badge bg-danger bg-gradient px-3 py-2">
                                        Còn lại: {{ $remainingTotal }}
                                    </span>
                                </div>
                                @endif
                                <div class="position-absolute top-0 end-0 m-3">
                                    <span class="badge {{ $item->category == 'event' ? 'bg-success' : 'bg-info' }} bg-gradient px-3 py-2">
                                        <i class="fas {{ $item->category == 'event' ? 'fa-calendar' : 'fa-map-marker-alt' }} me-1"></i>
                                        {{ $item->category_name }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title fw-bold mb-3">{{ $item->name }}</h5>
                                
                                @if($item->short_description)
                                <p class="card-text text-muted mb-3">{{ Str::limit($item->short_description, 100) }}</p>
                                @endif
                                
                                <div class="price-info mb-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="price-label">Người lớn:</span>
                                        <span class="price-value fw-bold text-primary">{{ number_format($item->adult_price) }}₫</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="price-label">Trẻ em:</span>
                                        <span class="price-value fw-bold text-success">{{ number_format($item->child_price) }}₫</span>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                        <span class="location-tag">{{ $item->location }}</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-clock text-primary me-2"></i>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($item->opening_time)->format('H:i') }} - 
                                            {{ \Carbon\Carbon::parse($item->closing_time)->format('H:i') }}
                                        </small>
                                    </div>
                                </div>
                                
                                <div class="mt-auto">
                                    <a href="{{ route('events.show', $item) }}" class="btn {{ $item->category == 'event' ? 'btn-primary' : 'btn-success' }} w-100">
                                        <i class="fas fa-eye me-2"></i>Xem chi tiết
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        
        @if($items->count() > 3)
        <!-- Navigation buttons -->
        <button class="carousel-btn carousel-btn-prev" onclick="moveCarousel('{{ $itemType }}', -1)">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button class="carousel-btn carousel-btn-next" onclick="moveCarousel('{{ $itemType }}', 1)">
            <i class="fas fa-chevron-right"></i>
        </button>
        
        <!-- Dots indicator -->
        <div class="carousel-dots text-center mt-4">
            @php
                $totalSlides = ceil($items->count() / 3);
            @endphp
            @for($i = 0; $i < $totalSlides; $i++)
                <button class="carousel-dot {{ $i === 0 ? 'active' : '' }}" 
                        onclick="goToSlide('{{ $itemType }}', {{ $i }})"></button>
            @endfor
        </div>
        @endif
    </div>
    @else
    <div class="text-center py-5">
        <i class="fas fa-search fa-4x text-muted mb-4"></i>
        <h3 class="text-muted mb-3">Chưa có {{ strtolower($title) }}</h3>
        <p class="text-muted">Hiện tại chưa có {{ strtolower($title) }} nào</p>
    </div>
    @endif
</div>

<style>
.carousel-container {
    position: relative;
}

.carousel-wrapper {
    overflow: hidden;
    border-radius: 10px;
}

.carousel-track {
    transition: transform 0.5s ease-in-out;
    display: flex;
}

.carousel-slide {
    flex: 0 0 16.666%;
    padding: 0 8px;
}

.carousel-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255, 255, 255, 0.9);
    border: none;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    color: #333;
    cursor: pointer;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    z-index: 10;
}

.carousel-btn:hover {
    background: white;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    transform: translateY(-50%) scale(1.1);
}

.carousel-btn-prev {
    left: -25px;
}

.carousel-btn-next {
    right: -25px;
}

.carousel-dots {
    margin-top: 20px;
}

.carousel-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: none;
    background: #ddd;
    margin: 0 5px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.carousel-dot.active {
    background: #007bff;
    transform: scale(1.2);
}

.carousel-dot:hover {
    background: #007bff;
    opacity: 0.7;
}

@media (max-width: 992px) {
    .carousel-slide {
        flex: 0 0 50%;
    }
}

@media (max-width: 768px) {
    .carousel-slide {
        flex: 0 0 50%;
    }
    
    .carousel-btn {
        width: 40px;
        height: 40px;
        font-size: 14px;
    }
    
    .carousel-btn-prev {
        left: -20px;
    }
    
    .carousel-btn-next {
        right: -20px;
    }
}

@media (max-width: 576px) {
    .carousel-slide {
        flex: 0 0 100%;
    }
}
</style>

<script>
let carouselPositions = {};

function initCarousel(type) {
    carouselPositions[type] = 0;
}

function moveCarousel(type, direction) {
    const track = document.getElementById(`carousel-track-${type}`);
    const slides = track.querySelectorAll('.carousel-slide');
    const totalSlides = slides.length;
    const slidesPerView = 3;
    const maxPosition = Math.max(0, totalSlides - slidesPerView);
    
    carouselPositions[type] += direction;
    carouselPositions[type] = Math.max(0, Math.min(carouselPositions[type], maxPosition));
    
    const translateX = -(carouselPositions[type] * (100 / slidesPerView));
    track.style.transform = `translateX(${translateX}%)`;
    
    updateDots(type);
}

function goToSlide(type, slideIndex) {
    const track = document.getElementById(`carousel-track-${type}`);
    const slides = track.querySelectorAll('.carousel-slide');
    const totalSlides = slides.length;
    const slidesPerView = 3;
    const maxPosition = Math.max(0, totalSlides - slidesPerView);
    
    carouselPositions[type] = Math.min(slideIndex, maxPosition);
    
    const translateX = -(carouselPositions[type] * (100 / slidesPerView));
    track.style.transform = `translateX(${translateX}%)`;
    
    updateDots(type);
}

function updateDots(type) {
    const dots = document.querySelectorAll(`#carousel-track-${type}`).parentElement.querySelectorAll('.carousel-dot');
    const currentSlide = Math.floor(carouselPositions[type] / 3);
    
    dots.forEach((dot, index) => {
        dot.classList.toggle('active', index === currentSlide);
    });
}

// Initialize carousels when page loads
document.addEventListener('DOMContentLoaded', function() {
    initCarousel('attractions');
    initCarousel('events');
});
</script>
