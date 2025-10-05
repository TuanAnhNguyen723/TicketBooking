@extends('admin.layout')

@section('title', 'Chi tiết vé')

@section('content')
<h2 class="text-xl font-semibold text-gray-800 mb-4">Vé #{{ $ticket->id }}</h2>

<div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-3 text-sm text-gray-700">
    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
        <div><span class="text-gray-500">Đơn:</span> {{ optional($ticket->order)->order_number }}</div>
        <div><span class="text-gray-500">Sự kiện:</span> {{ optional($ticket->event)->name }}</div>
        <div><span class="text-gray-500">Loại:</span> {{ $ticket->type }}</div>
        <div><span class="text-gray-500">Giá:</span> {{ $ticket->price }}</div>
        <div><span class="text-gray-500">Ngày tham quan:</span> {{ $ticket->visit_date }}</div>
        <div><span class="text-gray-500">Trạng thái:</span> {{ $ticket->status }}</div>
        <a href="{{ route('admin.tickets.edit', $ticket) }}" class="inline-flex items-center mt-3 px-3 py-2 rounded-lg bg-amber-600 text-white hover:bg-amber-700">Sửa</a>
    </div>
@endsection


