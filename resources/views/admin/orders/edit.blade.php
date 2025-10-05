@extends('admin.layout')

@section('title', 'Sửa đơn hàng')

@section('content')
<h2 class="text-xl font-semibold text-gray-800 mb-4">Sửa đơn hàng #{{ $order->order_number }}</h2>

<form action="{{ route('admin.orders.update', $order) }}" method="POST" class="space-y-6">
    @csrf
    @method('PUT')

    <label class="form-label">Trạng thái
        <select name="status" class="form-select">
            @foreach (['paid','pending','cancelled','refunded'] as $status)
                <option value="{{ $status }}" {{ $order->status === $status ? 'selected' : '' }}>{{ $status }}</option>
            @endforeach
        </select>
    </label>
    <label class="form-label">Phương thức thanh toán
        <input type="text" name="payment_method" value="{{ old('payment_method', $order->payment_method) }}" class="form-input">
    </label>
    <label class="form-label">Mã tham chiếu
        <input type="text" name="payment_reference" value="{{ old('payment_reference', $order->payment_reference) }}" class="form-input">
    </label>

    <div class="pt-2">
        <button type="submit" class="px-4 py-2 rounded-lg bg-primary-600 text-white hover:bg-primary-700">Lưu</button>
        <a href="{{ route('admin.orders.show', $order) }}" class="ml-2 text-gray-600 hover:text-gray-900">Hủy</a>
    </div>
</form>
@endsection


