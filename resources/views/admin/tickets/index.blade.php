@extends('admin.layout')

@section('title', 'Vé')

@section('content')
<h2 class="text-xl font-semibold text-gray-800 mb-4">Danh sách vé</h2>

<div class="overflow-x-auto">
    <table class="min-w-full text-sm text-gray-700">
        <thead>
            <tr class="bg-gray-50 text-left">
                <th class="py-3 px-4 text-gray-500 font-semibold">#</th>
                <th class="py-3 px-4 text-gray-500 font-semibold">Đơn</th>
                <th class="py-3 px-4 text-gray-500 font-semibold">Sự kiện</th>
                <th class="py-3 px-4 text-gray-500 font-semibold">Loại</th>
                <th class="py-3 px-4 text-gray-500 font-semibold">Giá</th>
                <th class="py-3 px-4 text-gray-500 font-semibold">Ngày tham quan</th>
                <th class="py-3 px-4 text-gray-500 font-semibold">Trạng thái</th>
                <th class="py-3 px-4 text-gray-500 font-semibold">Hành động</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach ($tickets as $ticket)
                <tr class="hover:bg-gray-50">
                    <td class="py-3 px-4">{{ $ticket->id }}</td>
                    <td class="py-3 px-4">{{ optional($ticket->order)->order_number }}</td>
                    <td class="py-3 px-4">{{ optional($ticket->event)->name }}</td>
                    <td class="py-3 px-4">{{ $ticket->type }}</td>
                    <td class="py-3 px-4">{{ $ticket->price }}</td>
                    <td class="py-3 px-4">{{ $ticket->visit_date }}</td>
                    <td class="py-3 px-4">{{ $ticket->status }}</td>
                    <td class="py-3 px-4">
                        <div class="flex items-center gap-3">
                            <a href="{{ route('admin.tickets.show', $ticket) }}" class="text-primary-600 hover:underline">Xem</a>
                            <a href="{{ route('admin.tickets.edit', $ticket) }}" class="text-amber-600 hover:underline">Sửa</a>
                            <form action="{{ route('admin.tickets.destroy', $ticket) }}" method="POST" onsubmit="return confirm('Xóa vé này?');">
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
    {{ $tickets->onEachSide(1)->links('admin.pagination') }}
 </div>
@endsection


