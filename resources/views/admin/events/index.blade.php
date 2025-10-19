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
                    <th class="py-3 px-4 text-gray-500 font-semibold">Loại</th>
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
                        <td class="py-3 px-4">
                            <div class="flex items-center gap-3">
                                @if($event->image)
                                <div class="w-12 h-12 rounded-lg overflow-hidden flex-shrink-0">
                                    <img src="{{ asset($event->image) }}" alt="{{ $event->name }}" class="w-full h-full object-cover">
                                </div>
                                @else
                                <div class="w-12 h-12 rounded-lg bg-gray-200 flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-image text-gray-400"></i>
                                </div>
                                @endif
                                <div>
                                    <div class="font-medium text-gray-900">{{ $event->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $event->location }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-3 px-4">
                            <span class="inline-flex items-center rounded-full {{ $event->category == 'event' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }} px-2.5 py-0.5 text-xs font-medium">
                                <i class="fas {{ $event->category == 'event' ? 'fa-calendar' : 'fa-map-marker-alt' }} me-1"></i>
                                {{ $event->category_name }}
                            </span>
                            @if($event->category == 'event' && $event->status_name)
                            <br>
                            <span class="inline-flex items-center rounded-full bg-{{ $event->status_color }}-100 text-{{ $event->status_color }}-800 px-2.5 py-0.5 text-xs font-medium mt-1">
                                <i class="fas {{ $event->status == 'upcoming' ? 'fa-clock' : ($event->status == 'ongoing' ? 'fa-play' : 'fa-stop') }} me-1"></i>
                                {{ $event->status_name }}
                            </span>
                            @endif
                        </td>
                        <td class="py-3 px-4">{{ $event->start_date }} → {{ $event->end_date }}</td>
                        <td class="py-3 px-4">{{ number_format($event->adult_price) }}₫ / {{ number_format($event->child_price) }}₫</td>
                        <td class="py-3 px-4">
                            @if ($event->is_active)
                                <span class="inline-flex items-center rounded-full bg-green-100 text-green-800 px-2.5 py-0.5 text-xs font-medium">Active</span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-gray-100 text-gray-700 px-2.5 py-0.5 text-xs font-medium">Inactive</span>
                            @endif
                        </td>
                        <td class="py-3 px-4">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('admin.events.show', $event) }}" class="text-blue-600 hover:underline">Xem</a>
                                <a href="{{ route('admin.events.edit', $event) }}" class="text-primary-600 hover:underline">Sửa</a>
                                <form action="{{ route('admin.events.destroy', $event) }}" method="POST" onsubmit="return confirm('Xóa sự kiện này?');" class="inline">
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


