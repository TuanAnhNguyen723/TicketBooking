@extends('admin.layout')

@section('title', 'Sửa người dùng')

@section('content')
<h2 class="text-xl font-semibold text-gray-800 mb-4">Sửa {{ $user->email }}</h2>

<form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-6">
    @csrf
    @method('PUT')
    <label class="form-label">Tên
        <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="form-input">
    </label>
    <label class="form-label">Email
        <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="form-input">
    </label>
    <label class="form-label">Mật khẩu (để trống nếu không đổi)
        <input type="password" name="password" class="form-input">
    </label>

    <div class="pt-2">
        <button type="submit" class="px-4 py-2 rounded-lg bg-primary-600 text-white hover:bg-primary-700">Lưu</button>
        <a href="{{ route('admin.users.show', $user) }}" class="ml-2 text-gray-600 hover:text-gray-900">Hủy</a>
    </div>
</form>
@endsection


