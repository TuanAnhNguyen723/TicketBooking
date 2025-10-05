@extends('admin.layout')

@section('title', 'Sửa đánh giá')

@section('content')
<h2 class="text-xl font-semibold text-gray-800 mb-4">Sửa đánh giá #{{ $review->id }}</h2>

<form action="{{ route('admin.reviews.update', $review) }}" method="POST" class="space-y-6">
    @csrf
    @method('PUT')
    <label class="form-label">Điểm (1-5)
        <input type="number" name="rating" min="1" max="5" value="{{ old('rating', $review->rating) }}" class="form-input w-32">
    </label>
    <label class="form-label">Bình luận
        <textarea name="comment" rows="4" class="form-textarea">{{ old('comment', $review->comment) }}</textarea>
    </label>

    <div class="pt-2">
        <button type="submit" class="px-4 py-2 rounded-lg bg-primary-600 text-white hover:bg-primary-700">Lưu</button>
        <a href="{{ route('admin.reviews.show', $review) }}" class="ml-2 text-gray-600 hover:text-gray-900">Hủy</a>
    </div>
</form>
@endsection


