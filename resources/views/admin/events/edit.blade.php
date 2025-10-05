@extends('admin.layout')

@section('title', 'Sửa sự kiện')

@section('content')
<div class="mb-4 flex items-center justify-between">
    <div>
        <h2 class="text-xl font-semibold text-gray-800">Sửa sự kiện</h2>
        <p class="text-gray-500 text-sm">Cập nhật thông tin, lịch và tồn kho vé cho sự kiện</p>
    </div>
    <a href="{{ route('admin.events.show', $event) }}" class="px-3 py-2 rounded-lg border border-gray-200 text-gray-700 hover:bg-gray-50">Quay lại</a>
 </div>

<form action="{{ route('admin.events.update', $event) }}" method="POST" class="space-y-6">
    @csrf
    @method('PUT')

    <!-- Thông tin cơ bản -->
    <div class="bg-white border border-gray-200 rounded-xl p-5">
        <h3 class="font-semibold text-gray-800 mb-4">Thông tin cơ bản</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <label class="form-label">Tên sự kiện
                <input type="text" name="name" value="{{ old('name', $event->name) }}" required class="form-input" placeholder="Tên nổi bật, dễ hiểu">
            </label>
            <label class="form-label">Địa điểm
                <input type="text" name="location" value="{{ old('location', $event->location) }}" required class="form-input" placeholder="vd: Phú Quốc, Kiên Giang">
            </label>
            <label class="form-label md:col-span-2">Mô tả ngắn
                <input type="text" name="short_description" value="{{ old('short_description', $event->short_description) }}" class="form-input" placeholder="Tối đa 1-2 câu tóm tắt...">
            </label>
            <label class="form-label md:col-span-2">Mô tả chi tiết
                <textarea name="description" rows="6" class="form-textarea" placeholder="Mô tả đầy đủ về sự kiện">{{ old('description', $event->description) }}</textarea>
            </label>
        </div>
    </div>

    <!-- Giá & Lịch -->
    <div class="bg-white border border-gray-200 rounded-xl p-5">
        <h3 class="font-semibold text-gray-800 mb-4">Giá & Lịch</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <label class="form-label">Giá người lớn
                <input type="number" step="0.01" name="adult_price" value="{{ old('adult_price', $event->adult_price) }}" required class="form-input">
            </label>
            <label class="form-label">Giá trẻ em
                <input type="number" step="0.01" name="child_price" value="{{ old('child_price', $event->child_price) }}" required class="form-input">
            </label>
            <label class="form-label">Ngày bắt đầu
                <input type="date" name="start_date" value="{{ old('start_date', optional($event->start_date)->format('Y-m-d')) }}" required class="form-input">
            </label>
            <label class="form-label">Ngày kết thúc
                <input type="date" name="end_date" value="{{ old('end_date', optional($event->end_date)->format('Y-m-d')) }}" required class="form-input">
            </label>
            <label class="form-label">Giờ mở cửa
                <input type="time" name="opening_time" value="{{ old('opening_time', optional($event->opening_time)->format('H:i')) }}" class="form-input">
            </label>
            <label class="form-label">Giờ đóng cửa
                <input type="time" name="closing_time" value="{{ old('closing_time', optional($event->closing_time)->format('H:i')) }}" class="form-input">
            </label>
        </div>
    </div>

    <!-- Ảnh & Tồn kho -->
    <div class="bg-white border border-gray-200 rounded-xl p-5">
        <h3 class="font-semibold text-gray-800 mb-4">Ảnh & Tồn kho</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <label class="form-label">Ảnh đại diện (đường dẫn)
                <input type="text" name="image" value="{{ old('image', $event->image) }}" class="form-input" placeholder="vd: vinwonders-main.jpg">
            </label>
            <!-- Bỏ trường tồn kho theo ngày -->
            <label class="form-label">Tổng số vé (để trống nếu không giới hạn)
                <input type="number" min="0" name="total_capacity" value="{{ old('total_capacity', $event->total_capacity) }}" class="form-input">
            </label>
            <label class="form-label md:col-span-2">Gallery (JSON array)
                <textarea name="gallery" rows="3" class="form-textarea" placeholder='["image-1.jpg","image-2.jpg"]'>{{ old('gallery', json_encode($event->gallery)) }}</textarea>
                <span class="form-hint">Nhập mảng JSON tên file ảnh trong thư mục <code>public/images/events</code>.</span>
            </label>
            <label class="inline-flex items-center gap-2 md:col-span-2">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $event->is_active) ? 'checked' : '' }} class="form-checkbox">
                <span>Kích hoạt</span>
            </label>
        </div>
    </div>

    <div class="flex items-center gap-2">
        <button type="submit" class="px-4 py-2 rounded-lg bg-primary-600 text-white hover:bg-primary-700">Cập nhật</button>
        <a href="{{ route('admin.events.index') }}" class="px-4 py-2 rounded-lg border border-gray-200 text-gray-700 hover:bg-gray-50">Hủy</a>
    </div>
</form>
@endsection


