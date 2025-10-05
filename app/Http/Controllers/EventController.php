<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Ticket;

class EventController extends Controller
{
    /**
     * Hiển thị trang chủ với danh sách sự kiện
     */
    public function index()
    {
        $events = Event::where('is_active', true)
            ->where('end_date', '>=', now()->toDateString())
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        return view('events.index', compact('events'));
    }

    /**
     * Tìm kiếm sự kiện
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        
        $events = Event::where('is_active', true)
            ->where('end_date', '>=', now()->toDateString())
            ->when($query, function ($q) use ($query) {
                return $q->where('name', 'like', "%{$query}%")
                       ->orWhere('location', 'like', "%{$query}%")
                       ->orWhere('description', 'like', "%{$query}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        return view('events.index', compact('events', 'query'));
    }

    /**
     * Hiển thị chi tiết sự kiện
     */
    public function show(Event $event)
    {
        $reviews = $event->reviews()->with('user')->latest()->take(5)->get();
        
        return view('events.show', compact('event', 'reviews'));
    }

    /**
     * Trả về số vé còn lại (theo tổng capacity)
     */
    public function availability(Request $request, Event $event)
    {
        if (is_null($event->total_capacity)) {
            return response()->json(['unlimited' => true, 'remaining' => null]);
        }

        $sold = Ticket::where('event_id', $event->id)
            ->whereIn('status', ['paid', 'checked_in'])
            ->count();

        $remaining = max(0, $event->total_capacity - $sold);

        return response()->json(['unlimited' => false, 'remaining' => $remaining]);
    }
}
