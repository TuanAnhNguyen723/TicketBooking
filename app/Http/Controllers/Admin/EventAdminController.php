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
            'category' => 'required|in:event,attraction',
            'short_description' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'adult_price' => 'required|numeric|min:0',
            'child_price' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'opening_time' => 'nullable|date_format:H:i',
            'closing_time' => 'nullable|date_format:H:i',
            'is_active' => 'nullable|boolean',
            'total_capacity' => 'nullable|integer|min:0',
        ]);

        // Xử lý upload ảnh đại diện
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/events'), $imageName);
            $data['image'] = 'images/events/' . $imageName;
        }

        // Xử lý upload gallery images
        if ($request->hasFile('gallery_images')) {
            $galleryImages = [];
            foreach ($request->file('gallery_images') as $galleryImage) {
                $galleryImageName = time() . '_' . uniqid() . '_' . $galleryImage->getClientOriginalName();
                $galleryImage->move(public_path('images/events'), $galleryImageName);
                $galleryImages[] = 'images/events/' . $galleryImageName;
            }
            $data['gallery'] = $galleryImages;
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
            'category' => 'required|in:event,attraction',
            'short_description' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'adult_price' => 'required|numeric|min:0',
            'child_price' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'opening_time' => 'nullable|date_format:H:i',
            'closing_time' => 'nullable|date_format:H:i',
            'is_active' => 'nullable|boolean',
            'total_capacity' => 'nullable|integer|min:0',
        ]);

        // Xử lý upload ảnh đại diện mới
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu có
            if ($event->image && file_exists(public_path($event->image))) {
                unlink(public_path($event->image));
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/events'), $imageName);
            $data['image'] = 'images/events/' . $imageName;
        }

        // Xử lý upload gallery images mới
        if ($request->hasFile('gallery_images')) {
            // Xóa ảnh gallery cũ nếu có
            if ($event->gallery && is_array($event->gallery)) {
                foreach ($event->gallery as $oldImage) {
                    if (file_exists(public_path($oldImage))) {
                        unlink(public_path($oldImage));
                    }
                }
            }
            
            $galleryImages = [];
            foreach ($request->file('gallery_images') as $galleryImage) {
                $galleryImageName = time() . '_' . uniqid() . '_' . $galleryImage->getClientOriginalName();
                $galleryImage->move(public_path('images/events'), $galleryImageName);
                $galleryImages[] = 'images/events/' . $galleryImageName;
            }
            $data['gallery'] = $galleryImages;
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


