<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceCategory;
use App\Models\Queue;

class KioskController extends Controller
{
    public function index()
    {
        $services = ServiceCategory::all();
        return view('kiosk', compact('services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_category_id' => 'required|exists:service_categories,id'
        ]);

        
        $queue = Queue::create([
            'service_category_id' => $request->service_category_id,
            'ticket_number' => Queue::generateTicketNumber(),
            'sequence_number' => Queue::generateSequenceNumber(),
            'customer_name' => $request->customer_name,
            'status' => 'Menunggu',
            'queue_date' => now()->toDateString(),
        ]);

        $queuesAhead = Queue::where('queue_date', today())
            ->where('status', 'Menunggu')
            ->where('id', '<', $queue->id)
            ->count();

        return view('kiosk-success', compact('queue', 'queuesAhead'));
    }
}