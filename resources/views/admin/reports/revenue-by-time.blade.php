@extends('admin.layout')

@section('title', 'Báo cáo Doanh thu theo Thời gian')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                <i class="fas fa-chart-line text-primary-600"></i>
                Báo cáo Doanh thu theo Thời gian
            </h2>
            <p class="text-gray-600 mt-1">Theo dõi và phân tích doanh thu theo các khoảng thời gian khác nhau</p>
        </div>
    </div>
    
    <!-- Bộ lọc -->
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <form method="GET" action="{{ route('admin.reports.revenue-by-time') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            <div>
                <label for="period" class="form-label text-sm">Khoảng thời gian</label>
                <select name="period" id="period" class="form-select text-sm h-10 py-2">
                    <option value="day" {{ $period == 'day' ? 'selected' : '' }}>Theo ngày</option>
                    <option value="month" {{ $period == 'month' ? 'selected' : '' }}>Theo tháng</option>
                    <option value="year" {{ $period == 'year' ? 'selected' : '' }}>Theo năm</option>
                </select>
            </div>
            
            <div>
                <label for="start_date" class="form-label text-sm">Từ ngày</label>
                <input type="date" name="start_date" id="start_date" class="form-input text-sm h-10 py-2" 
                       value="{{ $startDate->format('Y-m-d') }}">
            </div>
            
            <div>
                <label for="end_date" class="form-label text-sm">Đến ngày</label>
                <input type="date" name="end_date" id="end_date" class="form-input text-sm h-10 py-2" 
                       value="{{ $endDate->format('Y-m-d') }}">
            </div>
            
            <div>
                <label for="ticket_type" class="form-label text-sm">Loại vé</label>
                <select name="ticket_type" id="ticket_type" class="form-select text-sm h-10 py-2">
                    <option value="all" {{ $ticketType == 'all' ? 'selected' : '' }}>Tất cả</option>
                    <option value="adult" {{ $ticketType == 'adult' ? 'selected' : '' }}>Người lớn</option>
                    <option value="child" {{ $ticketType == 'child' ? 'selected' : '' }}>Trẻ em</option>
                </select>
            </div>

            <div>
                <label for="location" class="form-label text-sm">Địa điểm</label>
                <select name="location" id="location" class="form-select text-sm h-10 py-2">
                    <option value="all" {{ ($location ?? 'all') == 'all' ? 'selected' : '' }}>Tất cả</option>
                    @php
                        $locations = $locations ?? \App\Models\Event::query()->select('location')->distinct()->orderBy('location')->pluck('location');
                    @endphp
                    @foreach($locations as $loc)
                        <option value="{{ $loc }}" {{ ($location ?? 'all') == $loc ? 'selected' : '' }}>{{ $loc }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="sm:col-span-2 lg:col-span-5 flex flex-wrap gap-2 mt-1">
                <button type="submit" class="bg-primary-600 text-white px-3 py-2 text-sm rounded-lg hover:bg-primary-700 transition flex items-center gap-2">
                    <i class="fas fa-filter"></i>
                    Lọc dữ liệu
                </button>
                <a href="{{ route('admin.reports.revenue-by-time') }}" class="bg-gray-600 text-white px-3 py-2 text-sm rounded-lg hover:bg-gray-700 transition flex items-center gap-2">
                    <i class="fas fa-sync-alt"></i>
                    Làm mới
                </a>
            </div>
        </form>
    </div>

    <!-- Thống kê tổng quan -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-xl p-6">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-3xl font-bold">{{ number_format($totalRevenue, 0, ',', '.') }} ₫</h3>
                    <p class="text-primary-100 mt-1">Tổng doanh thu</p>
                </div>
                <div class="text-4xl opacity-80">
                    <i class="fas fa-dollar-sign"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl p-6">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-3xl font-bold">{{ number_format($totalOrders) }}</h3>
                    <p class="text-green-100 mt-1">Tổng đơn hàng</p>
                </div>
                <div class="text-4xl opacity-80">
                    <i class="fas fa-shopping-cart"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl p-6">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-3xl font-bold">{{ number_format($totalTickets) }}</h3>
                    <p class="text-blue-100 mt-1">Tổng vé bán</p>
                </div>
                <div class="text-4xl opacity-80">
                    <i class="fas fa-ticket-alt"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-xl p-6">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-3xl font-bold">{{ $totalOrders > 0 ? number_format($totalRevenue / $totalOrders, 0, ',', '.') : 0 }} ₫</h3>
                    <p class="text-orange-100 mt-1">Đơn hàng trung bình</p>
                </div>
                <div class="text-4xl opacity-80">
                    <i class="fas fa-calculator"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Biểu đồ -->
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-chart-area text-blue-600"></i>
            Biểu đồ Doanh thu
        </h3>
        <div class="h-96">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    <!-- Bảng chi tiết -->
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-table text-green-600"></i>
            Chi tiết Doanh thu
        </h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ $period == 'day' ? 'Ngày' : ($period == 'month' ? 'Tháng' : 'Năm') }}
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Doanh thu (₫)
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Số đơn hàng
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Số vé bán
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Đơn hàng TB (₫)
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($revenueData as $data)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $data->date }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                            {{ number_format($data->revenue, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                            {{ $data->orders_count }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                            {{ $data->tickets_count }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                            {{ $data->orders_count > 0 ? number_format($data->revenue / $data->orders_count, 0, ',', '.') : 0 }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                            Không có dữ liệu trong khoảng thời gian này
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
window.chartConfig = {
    url: '{{ route("admin.reports.revenue-chart-data") }}',
    period: '{{ $period }}',
    startDate: '{{ $startDate->format("Y-m-d") }}',
    endDate: '{{ $endDate->format("Y-m-d") }}',
    ticketType: '{{ $ticketType }}',
    location: '{{ $location ?? 'all' }}'
};
</script>
<script src="{{ asset('js/revenue-chart.js') }}"></script>
@endsection