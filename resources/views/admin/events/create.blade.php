@extends('admin.layout')

@section('title', 'Tạo sự kiện')

@section('content')
<h2 class="text-xl font-semibold text-gray-800 mb-4">Tạo sự kiện</h2>

<form action="{{ route('admin.events.store') }}" method="POST" class="space-y-4">
    @csrf
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <label class="block text-sm">Tên
            <input type="text" name="name" value="{{ old('name') }}" required class="mt-1 w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
        </label>
        <label class="block text-sm">Địa điểm
            <input type="text" name="location" value="{{ old('location') }}" required class="mt-1 w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
        </label>
        <label class="block text-sm">Giá người lớn
            <input type="number" step="0.01" name="adult_price" value="{{ old('adult_price') }}" required class="mt-1 w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
        </label>
        <label class="block text-sm">Giá trẻ em
            <input type="number" step="0.01" name="child_price" value="{{ old('child_price') }}" required class="mt-1 w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
        </label>
        <label class="block text-sm">Ngày bắt đầu
            <input type="date" name="start_date" value="{{ old('start_date') }}" required class="mt-1 w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
        </label>
        <label class="block text-sm">Ngày kết thúc
            <input type="date" name="end_date" value="{{ old('end_date') }}" required class="mt-1 w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
        </label>
        <label class="block text-sm">Giờ mở cửa
            <input type="time" name="opening_time" value="{{ old('opening_time') }}" class="mt-1 w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
        </label>
        <label class="block text-sm">Giờ đóng cửa
            <input type="time" name="closing_time" value="{{ old('closing_time') }}" class="mt-1 w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
        </label>
        <label class="block text-sm">Ảnh đại diện (đường dẫn)
            <input type="text" name="image" value="{{ old('image') }}" class="mt-1 w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
        </label>
        <label class="block text-sm">Tổng số vé (để trống nếu không giới hạn)
            <input type="number" min="0" name="total_capacity" value="{{ old('total_capacity') }}" class="mt-1 w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
        </label>
        <label class="block text-sm">Gallery (JSON array)
            <textarea name="gallery" rows="3" class="mt-1 w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">{{ old('gallery') }}</textarea>
        </label>
        <label class="block text-sm md:col-span-2">Mô tả ngắn
            <input type="text" name="short_description" value="{{ old('short_description') }}" class="mt-1 w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
        </label>
        <label class="block text-sm md:col-span-2">Mô tả chi tiết
            <textarea name="description" rows="5" class="mt-1 w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">{{ old('description') }}</textarea>
        </label>
        <label class="inline-flex items-center gap-2 md:col-span-2">
            <input type="checkbox" name="is_active" value="1" {{ old('is_active') ? 'checked' : '' }} class="rounded">
            <span>Kích hoạt</span>
        </label>
    </div>

    <div class="pt-2">
        <button type="submit" class="px-4 py-2 rounded-lg bg-green-600 text-white hover:bg-green-700">Lưu</button>
        <a href="{{ route('admin.events.index') }}" class="ml-2 text-gray-600 hover:text-gray-900">Hủy</a>
    </div>
</form>
@endsection


