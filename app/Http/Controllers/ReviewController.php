<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Lưu đánh giá mới
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để đánh giá!');
        }

        $request->validate([
            'event_id' => 'required|exists:events,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        // Kiểm tra xem user đã đánh giá sự kiện này chưa
        $existingReview = Review::where('user_id', Auth::id())
            ->where('event_id', $request->event_id)
            ->first();

        if ($existingReview) {
            return back()->with('error', 'Bạn đã đánh giá sự kiện này rồi!');
        }

        // Kiểm tra xem user có đặt vé cho sự kiện này không
        $hasTicket = Auth::user()->orders()
            ->whereHas('tickets', function($query) use ($request) {
                $query->where('event_id', $request->event_id)
                      ->where('status', 'paid');
            })
            ->exists();

        if (!$hasTicket) {
            return back()->with('error', 'Bạn cần đặt vé để đánh giá sự kiện này!');
        }

        Review::create([
            'user_id' => Auth::id(),
            'event_id' => $request->event_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Cảm ơn bạn đã đánh giá!');
    }
}
