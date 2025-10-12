<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Hiển thị trang báo cáo doanh thu theo thời gian
     */
    public function revenueByTime(Request $request)
    {
        // Lấy tham số từ request
        $period = $request->get('period', 'day'); // day, month, year
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth());
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth());
        $ticketType = $request->get('ticket_type', 'all'); // all, adult, child

        // Chuyển đổi chuỗi ngày thành Carbon instance nếu cần
        if (is_string($startDate)) {
            $startDate = Carbon::parse($startDate);
        }
        if (is_string($endDate)) {
            $endDate = Carbon::parse($endDate);
        }

        // Query cơ bản cho orders
        $query = Order::where('status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with(['tickets' => function($q) use ($ticketType) {
                if ($ticketType !== 'all') {
                    $q->where('type', $ticketType);
                }
            }]);

        // Tính tổng doanh thu
        $totalRevenue = $query->get()->sum(function($order) {
            return $order->tickets->sum(function($ticket) {
                return $ticket->price * $ticket->quantity;
            });
        });

        // Tính doanh thu theo khoảng thời gian
        $revenueData = $this->getRevenueByPeriod($period, $startDate, $endDate, $ticketType);

        // Lấy thống kê tổng quan
        $totalOrders = Order::where('status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $totalTickets = Ticket::whereHas('order', function($q) use ($startDate, $endDate) {
                $q->where('status', 'paid')
                  ->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->when($ticketType !== 'all', function($q) use ($ticketType) {
                $q->where('type', $ticketType);
            })
            ->sum('quantity');

        return view('admin.reports.revenue-by-time', compact(
            'revenueData',
            'totalRevenue',
            'totalOrders',
            'totalTickets',
            'period',
            'startDate',
            'endDate',
            'ticketType'
        ));
    }

    /**
     * Lấy dữ liệu doanh thu theo khoảng thời gian
     */
    private function getRevenueByPeriod($period, $startDate, $endDate, $ticketType)
    {
        $query = DB::table('orders')
            ->join('tickets', 'orders.id', '=', 'tickets.order_id')
            ->where('orders.status', 'paid')
            ->whereBetween('orders.created_at', [$startDate, $endDate]);

        if ($ticketType !== 'all') {
            $query->where('tickets.type', $ticketType);
        }

        switch ($period) {
            case 'day':
                $query->select(
                    DB::raw('DATE(orders.created_at) as date'),
                    DB::raw('SUM(tickets.price * tickets.quantity) as revenue'),
                    DB::raw('COUNT(DISTINCT orders.id) as orders_count'),
                    DB::raw('SUM(tickets.quantity) as tickets_count')
                )
                ->groupBy('date')
                ->orderBy('date');
                break;

            case 'month':
                $query->select(
                    DB::raw('YEAR(orders.created_at) as year'),
                    DB::raw('MONTH(orders.created_at) as month'),
                    DB::raw('DATE_FORMAT(orders.created_at, "%Y-%m") as date'),
                    DB::raw('SUM(tickets.price * tickets.quantity) as revenue'),
                    DB::raw('COUNT(DISTINCT orders.id) as orders_count'),
                    DB::raw('SUM(tickets.quantity) as tickets_count')
                )
                ->groupBy('year', 'month', 'date')
                ->orderBy('year')
                ->orderBy('month');
                break;

            case 'year':
                $query->select(
                    DB::raw('YEAR(orders.created_at) as year'),
                    DB::raw('SUM(tickets.price * tickets.quantity) as revenue'),
                    DB::raw('COUNT(DISTINCT orders.id) as orders_count'),
                    DB::raw('SUM(tickets.quantity) as tickets_count')
                )
                ->groupBy('year')
                ->orderBy('year');
                break;
        }

        return $query->get();
    }

    /**
     * API endpoint để lấy dữ liệu cho biểu đồ
     */
    public function getRevenueChartData(Request $request)
    {
        $period = $request->get('period', 'day');
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth());
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth());
        $ticketType = $request->get('ticket_type', 'all');

        if (is_string($startDate)) {
            $startDate = Carbon::parse($startDate);
        }
        if (is_string($endDate)) {
            $endDate = Carbon::parse($endDate);
        }

        $data = $this->getRevenueByPeriod($period, $startDate, $endDate, $ticketType);

        return response()->json([
            'labels' => $data->pluck('date'),
            'revenue' => $data->pluck('revenue'),
            'orders' => $data->pluck('orders_count'),
            'tickets' => $data->pluck('tickets_count')
        ]);
    }
}
