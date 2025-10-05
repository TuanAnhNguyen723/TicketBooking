@extends('admin.layout')

@section('title', 'Sửa vé')

@section('content')
<h2 class="text-xl font-semibold text-gray-800 mb-4">Sửa vé #{{ $ticket->id }}</h2>

<form action="{{ route('admin.tickets.update', $ticket) }}" method="POST" class="space-y-6">
    @csrf
    @method('PUT')
    <label class="form-label">Trạng thái
        <select name="status" class="form-select">
            @foreach (['paid','refunded','cancelled','checked_in'] as $status)
                <option value="{{ $status }}" {{ $ticket->status === $status ? 'selected' : '' }}>{{ $status }}</option>
            @endforeach
        </select>
    </label>
    <label class="form-label">Ngày tham quan
        <input type="date" name="visit_date" value="{{ old('visit_date', optional($ticket->visit_date)->format('Y-m-d')) }}" class="form-input">
    </label>

    <div class="pt-2">
        <button type="submit" class="px-4 py-2 rounded-lg bg-primary-600 text-white hover:bg-primary-700">Lưu</button>
        <a href="{{ route('admin.tickets.show', $ticket) }}" class="ml-2 text-gray-600 hover:text-gray-900">Hủy</a>
    </div>
</form>
@endsection


