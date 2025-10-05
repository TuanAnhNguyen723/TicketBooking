@extends('admin.layout')

@section('title', 'Người dùng')

@section('content')
<h2 class="text-xl font-semibold text-gray-800 mb-4">Danh sách người dùng</h2>

<div class="overflow-x-auto">
    <table class="min-w-full text-sm text-gray-700">
        <thead>
            <tr class="bg-gray-50 text-left">
                <th class="py-3 px-4 text-gray-500 font-semibold">#</th>
                <th class="py-3 px-4 text-gray-500 font-semibold">Tên</th>
                <th class="py-3 px-4 text-gray-500 font-semibold">Email</th>
                <th class="py-3 px-4 text-gray-500 font-semibold">Hành động</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach ($users as $user)
                <tr class="hover:bg-gray-50">
                    <td class="py-3 px-4">{{ $user->id }}</td>
                    <td class="py-3 px-4 font-medium text-gray-900">{{ $user->name }}</td>
                    <td class="py-3 px-4">{{ $user->email }}</td>
                    <td class="py-3 px-4">
                        <div class="flex items-center gap-3">
                            <a href="{{ route('admin.users.show', $user) }}" class="text-primary-600 hover:underline">Xem</a>
                            <a href="{{ route('admin.users.edit', $user) }}" class="text-amber-600 hover:underline">Sửa</a>
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Xóa người dùng này?');">
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
    {{ $users->onEachSide(1)->links('admin.pagination') }}
 </div>
@endsection


