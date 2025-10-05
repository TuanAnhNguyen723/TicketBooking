@extends('admin.layout')

@section('title', 'Chi tiết đánh giá')

@section('content')
<h2 class="text-xl font-semibold text-gray-800 mb-4">Đánh giá #{{ $review->id }}</h2>

<div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-3 text-sm text-gray-700">
    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
        <div><span class="text-gray-500">Người dùng:</span> {{ optional($review->user)->email }}</div>
        <div><span class="text-gray-500">Sự kiện:</span> {{ optional($review->event)->name }}</div>
        <div><span class="text-gray-500">Điểm:</span> {{ $review->rating }}</div>
        <div><span class="text-gray-500">Bình luận:</span> {{ $review->comment }}</div>
        <a href="{{ route('admin.reviews.edit', $review) }}" class="inline-flex items-center mt-3 px-3 py-2 rounded-lg bg-amber-600 text-white hover:bg-amber-700">Sửa</a>
    </div>
</div>
@endsection


