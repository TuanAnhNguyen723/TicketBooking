@extends('admin.layout')

@section('title', 'Đánh giá')

@section('content')
<h2 class="text-xl font-semibold text-gray-800 mb-4">Danh sách đánh giá</h2>

<div class="overflow-x-auto">
    <table class="min-w-full text-sm text-gray-700">
        <thead>
            <tr class="bg-gray-50 text-left">
                <th class="py-3 px-4 text-gray-500 font-semibold">#</th>
                <th class="py-3 px-4 text-gray-500 font-semibold">Người dùng</th>
                <th class="py-3 px-4 text-gray-500 font-semibold">Sự kiện</th>
                <th class="py-3 px-4 text-gray-500 font-semibold">Điểm</th>
                <th class="py-3 px-4 text-gray-500 font-semibold">Bình luận</th>
                <th class="py-3 px-4 text-gray-500 font-semibold">Hành động</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach ($reviews as $review)
                <tr class="hover:bg-gray-50">
                    <td class="py-3 px-4">{{ $review->id }}</td>
                    <td class="py-3 px-4">{{ optional($review->user)->email }}</td>
                    <td class="py-3 px-4">{{ optional($review->event)->name }}</td>
                    <td class="py-3 px-4">{{ $review->rating }}</td>
                    <td class="py-3 px-4">{{ $review->comment }}</td>
                    <td class="py-3 px-4">
                        <div class="flex items-center gap-3">
                            <a href="{{ route('admin.reviews.show', $review) }}" class="text-primary-600 hover:underline">Xem</a>
                            <a href="{{ route('admin.reviews.edit', $review) }}" class="text-amber-600 hover:underline">Sửa</a>
                            <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" onsubmit="return confirm('Xóa đánh giá này?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Xóa</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $reviews->onEachSide(1)->links('admin.pagination') }}
 </div>
@endsection


