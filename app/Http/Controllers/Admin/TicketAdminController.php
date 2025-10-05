<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;

class TicketAdminController extends Controller
{
    public function index()
    {
        $tickets = Ticket::with(['event', 'order'])->orderBy('created_at', 'desc')->paginate(12);
        return view('admin.tickets.index', compact('tickets'));
    }

    public function show(Ticket $ticket)
    {
        $ticket->load(['event', 'order']);
        return view('admin.tickets.show', compact('ticket'));
    }

    public function edit(Ticket $ticket)
    {
        return view('admin.tickets.edit', compact('ticket'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $data = $request->validate([
            'status' => 'required|string|in:paid,refunded,cancelled,checked_in',
            'visit_date' => 'nullable|date',
        ]);

        $ticket->update($data);

        return redirect()->route('admin.tickets.show', $ticket)->with('success', 'Cập nhật vé thành công');
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return redirect()->route('admin.tickets.index')->with('success', 'Đã xóa vé');
    }
}


