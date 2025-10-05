<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;

class EventAdminController extends Controller
{
    public function index()
    {
        $events = Event::orderBy('created_at', 'desc')->paginate(12);
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function show(Event $event)
    {
        return view('admin.events.show', compact('event'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:255',
            'gallery' => 'nullable',
            'adult_price' => 'required|numeric|min:0',
            'child_price' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'opening_time' => 'nullable|date_format:H:i',
            'closing_time' => 'nullable|date_format:H:i',
            'is_active' => 'nullable|boolean',
            // daily_capacity removed
            'total_capacity' => 'nullable|integer|min:0',
        ]);

        // cast gallery JSON nếu có
        if ($request->filled('gallery')) {
            $data['gallery'] = json_decode($request->input('gallery'), true) ?? [];
        }

        $data['is_active'] = (bool) ($data['is_active'] ?? false);

        Event::create($data);

        return redirect()->route('admin.events.index')->with('success', 'Tạo sự kiện thành công');
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:255',
            'gallery' => 'nullable',
            'adult_price' => 'required|numeric|min:0',
            'child_price' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'opening_time' => 'nullable|date_format:H:i',
            'closing_time' => 'nullable|date_format:H:i',
            'is_active' => 'nullable|boolean',
            // daily_capacity removed
            'total_capacity' => 'nullable|integer|min:0',
        ]);

        if ($request->filled('gallery')) {
            $data['gallery'] = json_decode($request->input('gallery'), true) ?? [];
        }

        $data['is_active'] = (bool) ($data['is_active'] ?? false);

        $event->update($data);

        return redirect()->route('admin.events.index')->with('success', 'Cập nhật sự kiện thành công');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Đã xóa sự kiện');
    }
}


