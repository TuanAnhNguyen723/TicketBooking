@extends('admin.layout')

@section('title', 'Sự kiện')

@section('content')
<div class="flex items-center justify-between mb-4">
    <h2 class="text-xl font-semibold text-gray-800">Danh sách sự kiện</h2>
    <a href="{{ route('admin.events.create') }}" class="inline-flex items-center px-3 py-2 rounded-lg bg-primary-600 text-white hover:bg-primary-700">+ Tạo sự kiện</a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-gray-700">
            <thead>
                <tr class="bg-gray-50 text-left">
                    <th class="py-3 px-4 text-gray-500 font-semibold">#</th>
                    <th class="py-3 px-4 text-gray-500 font-semibold">Tên</th>
                    <th class="py-3 px-4 text-gray-500 font-semibold">Khoảng ngày</th>
                    <th class="py-3 px-4 text-gray-500 font-semibold">Giá (NL/TE)</th>
                    <th class="py-3 px-4 text-gray-500 font-semibold">Trạng thái</th>
                    <th class="py-3 px-4 text-gray-500 font-semibold">Hành động</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach ($events as $event)
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 px-4">{{ $event->id }}</td>
                        <td class="py-3 px-4 font-medium text-gray-900">{{ $event->name }}</td>
                        <td class="py-3 px-4">{{ $event->start_date }} → {{ $event->end_date }}</td>
                        <td class="py-3 px-4">{{ $event->adult_price }} / {{ $event->child_price }}</td>
                        <td class="py-3 px-4">
                            @if ($event->is_active)
                                <span class="inline-flex items-center rounded-full bg-green-100 text-green-800 px-2.5 py-0.5 text-xs font-medium">Active</span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-gray-100 text-gray-700 px-2.5 py-0.5 text-xs font-medium">Inactive</span>
                            @endif
                        </td>
                        <td class="py-3 px-4">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('admin.events.edit', $event) }}" class="text-primary-600 hover:underline">Sửa</a>
                                <form action="{{ route('admin.events.destroy', $event) }}" method="POST" onsubmit="return confirm('Xóa sự kiện này?');">
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
        {{ $events->onEachSide(1)->links('admin.pagination') }}
    </div>
@endsection


