@extends('admin.layout')

@section('title', 'Đơn hàng')

@section('content')
<h2 class="text-xl font-semibold text-gray-800 mb-4">Danh sách đơn hàng</h2>

<div class="overflow-x-auto">
    <table class="min-w-full text-sm text-gray-700">
        <thead>
            <tr class="bg-gray-50 text-left">
                <th class="py-3 px-4 text-gray-500 font-semibold">#</th>
                <th class="py-3 px-4 text-gray-500 font-semibold">Mã đơn</th>
                <th class="py-3 px-4 text-gray-500 font-semibold">Người dùng</th>
                <th class="py-3 px-4 text-gray-500 font-semibold">Tổng tiền</th>
                <th class="py-3 px-4 text-gray-500 font-semibold">Trạng thái</th>
                <th class="py-3 px-4 text-gray-500 font-semibold">Hành động</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach ($orders as $order)
                <tr class="hover:bg-gray-50">
                    <td class="py-3 px-4">{{ $order->id }}</td>
                    <td class="py-3 px-4 font-medium text-gray-900">{{ $order->order_number }}</td>
                    <td class="py-3 px-4">{{ optional($order->user)->email }}</td>
                    <td class="py-3 px-4">{{ $order->total_amount }}</td>
                    <td class="py-3 px-4">
                        <span class="inline-flex items-center rounded-full bg-gray-100 text-gray-700 px-2.5 py-0.5 text-xs font-medium">{{ $order->status }}</span>
                    </td>
                    <td class="py-3 px-4">
                        <div class="flex items-center gap-3">
                            <a href="{{ route('admin.orders.show', $order) }}" class="text-primary-600 hover:underline">Xem</a>
                            <a href="{{ route('admin.orders.edit', $order) }}" class="text-amber-600 hover:underline">Sửa</a>
                            <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Xóa đơn hàng này?');">
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
    {{ $orders->onEachSide(1)->links('admin.pagination') }}
 </div>
@endsection


