@extends('admin.layout')

@section('title', 'Chi tiết người dùng')

@section('content')
<h2 class="text-xl font-semibold text-gray-800 mb-4">{{ $user->name }} ({{ $user->email }})</h2>

<h3 class="font-semibold text-gray-800 mb-2">Đơn hàng</h3>
<ul class="list-disc pl-5 text-sm text-gray-700 space-y-1">
    @foreach ($user->orders as $order)
        <li><a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600 hover:underline">#{{ $order->order_number }} - {{ $order->status }} - {{ $order->total_amount }}</a></li>
    @endforeach
 </ul>

 <h3 class="font-semibold text-gray-800 mb-2 mt-4">Đánh giá</h3>
 <ul class="list-disc pl-5 text-sm text-gray-700 space-y-1">
    @foreach ($user->reviews as $review)
        <li>{{ optional($review->event)->name }}: {{ $review->rating }}★ - {{ $review->comment }}</li>
    @endforeach
 </ul>
@endsection


