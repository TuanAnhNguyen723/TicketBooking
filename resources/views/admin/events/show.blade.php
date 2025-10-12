@extends('admin.layout')

@section('title', 'Chi tiết sự kiện')

@section('content')
<div class="flex items-center justify-between mb-4">
    <h2 class="text-xl font-semibold text-gray-800">{{ $event->name }}</h2>
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.events.edit', $event) }}" class="px-3 py-2 rounded-lg bg-amber-600 text-white hover:bg-amber-700">Sửa</a>
        <a href="{{ route('admin.events.index') }}" class="px-3 py-2 rounded-lg border border-gray-200 text-gray-700 hover:bg-gray-50">Quay lại</a>
    </div>
 </div>

 <!-- Ảnh và thông tin cơ bản -->
 <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Ảnh đại diện -->
    <div class="lg:col-span-1">
        <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">
            <h3 class="font-semibold text-gray-900 mb-3 flex items-center gap-2">
                <i class="fas fa-image text-blue-600"></i>
                Ảnh đại diện
            </h3>
            @if($event->image)
            <div class="aspect-square bg-white border-2 border-gray-200 rounded-xl overflow-hidden">
                <img src="{{ asset($event->image) }}" alt="{{ $event->name }}" class="w-full h-full object-cover">
            </div>
            @else
            <div class="aspect-square bg-gray-200 border-2 border-gray-300 rounded-xl flex items-center justify-center">
                <div class="text-center text-gray-400">
                    <i class="fas fa-image text-4xl mb-2"></i>
                    <p class="text-sm">Chưa có ảnh</p>
                </div>
            </div>
            @endif
        </div>
        
        <!-- Thư viện ảnh -->
        @if($event->gallery && count($event->gallery) > 0)
        <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 mt-4">
            <h3 class="font-semibold text-gray-900 mb-3 flex items-center gap-2">
                <i class="fas fa-images text-green-600"></i>
                Thư viện ảnh
            </h3>
            <div class="grid grid-cols-2 gap-2">
                @foreach($event->gallery as $galleryImage)
                <div class="aspect-square bg-white border-2 border-gray-200 rounded-lg overflow-hidden">
                    <img src="{{ asset($galleryImage) }}" alt="Gallery image" class="w-full h-full object-cover">
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
    
    <!-- Thông tin chi tiết -->
    <div class="lg:col-span-2">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 space-y-2">
                <div><span class="text-gray-500">Địa điểm:</span> {{ $event->location }}</div>
                <div><span class="text-gray-500">Khoảng ngày:</span> {{ $event->start_date }} → {{ $event->end_date }}</div>
                <div><span class="text-gray-500">Giờ mở cửa:</span> {{ $event->opening_time }}</div>
                <div><span class="text-gray-500">Giờ đóng cửa:</span> {{ $event->closing_time }}</div>
                <div><span class="text-gray-500">Giá NL/TE:</span> {{ number_format($event->adult_price) }}₫ / {{ number_format($event->child_price) }}₫</div>
                <div><span class="text-gray-500">Tổng số vé:</span> {{ $event->total_capacity ? $event->total_capacity : 'Không giới hạn' }}</div>
                <div><span class="text-gray-500">Trạng thái:</span>
                    @if ($event->is_active)
                        <span class="inline-flex items-center rounded-full bg-green-100 text-green-800 px-2 py-0.5 text-xs font-medium">Active</span>
                    @else
                        <span class="inline-flex items-center rounded-full bg-gray-100 text-gray-700 px-2 py-0.5 text-xs font-medium">Inactive</span>
                    @endif
                </div>
            </div>
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 space-y-2">
                <div class="text-gray-500">Mô tả ngắn</div>
                <div class="text-gray-800">{{ $event->short_description }}</div>
                <div class="text-gray-500">Mô tả chi tiết</div>
                <div class="text-gray-800 whitespace-pre-line">{{ $event->description }}</div>
            </div>
        </div>
    </div>
 </div>

 <div class="mt-4 bg-white border border-gray-200 rounded-xl p-4">
    <h3 class="font-semibold text-gray-800 mb-3">Kiểm tra tồn kho theo ngày</h3>
    <div class="flex flex-wrap gap-3 items-center">
        <input type="date" id="admin_check_date" class="rounded-lg border-gray-300">
        <button id="admin_check_btn" class="px-3 py-2 rounded-lg bg-primary-600 text-white">Kiểm tra</button>
        <div id="admin_check_result" class="text-sm text-gray-700"></div>
    </div>
 </div>

 @push('head')
 <script>
    document.addEventListener('DOMContentLoaded', () => {
        const input = document.getElementById('admin_check_date');
        const btn = document.getElementById('admin_check_btn');
        const result = document.getElementById('admin_check_result');
        if (!input || !btn) return;
        btn.addEventListener('click', async () => {
            if (!input.value) { result.textContent = 'Chọn ngày để kiểm tra.'; return; }
            const res = await fetch(`{{ route('events.availability', $event) }}?date=${input.value}`);
            const data = await res.json();
            result.textContent = data.unlimited ? 'Không giới hạn' : `Còn lại: ${data.remaining} vé`;
        });
    });
 </script>
 @endpush
@endsection


