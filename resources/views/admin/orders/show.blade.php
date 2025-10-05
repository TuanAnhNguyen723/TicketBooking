@extends('admin.layout')

@section('title', 'Chi tiết đơn hàng')

@section('content')
<h2 class="text-xl font-semibold text-gray-800 mb-4">Đơn #{{ $order->order_number }}</h2>

<div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-3 text-sm text-gray-700">
    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
        <div><span class="text-gray-500">Người dùng:</span> {{ optional($order->user)->email }}</div>
        <div><span class="text-gray-500">Tổng tiền:</span> {{ $order->total_amount }}</div>
        <div><span class="text-gray-500">Trạng thái:</span> <span class="inline-flex items-center rounded-full bg-gray-100 text-gray-700 px-2 py-0.5 text-xs font-medium">{{ $order->status }}</span></div>
        <div><span class="text-gray-500">Phương thức:</span> {{ $order->payment_method }}</div>
        <div><span class="text-gray-500">Tham chiếu:</span> {{ $order->payment_reference }}</div>
        <a href="{{ route('admin.orders.edit', $order) }}" class="inline-flex items-center mt-3 px-3 py-2 rounded-lg bg-amber-600 text-white hover:bg-amber-700">Sửa</a>
    </div>
</div>

<h3 class="font-semibold text-gray-800 mb-2">Danh sách vé</h3>
<div class="overflow-x-auto">
    <table class="min-w-full text-sm text-gray-700">
        <thead>
            <tr class="border-b bg-gray-50 text-left">
                <th class="py-2 px-3">#</th>
                <th class="py-2 px-3">Sự kiện</th>
                <th class="py-2 px-3">Loại</th>
                <th class="py-2 px-3">Giá</th>
                <th class="py-2 px-3">Ngày tham quan</th>
                <th class="py-2 px-3">Trạng thái</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->tickets as $ticket)
                <tr class="border-b hover:bg-gray-50">
                    <td class="py-2 px-3">{{ $ticket->id }}</td>
                    <td class="py-2 px-3">{{ optional($ticket->event)->name }}</td>
                    <td class="py-2 px-3">{{ $ticket->type }}</td>
                    <td class="py-2 px-3">{{ $ticket->price }}</td>
                    <td class="py-2 px-3">{{ $ticket->visit_date }}</td>
                    <td class="py-2 px-3">{{ $ticket->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection


