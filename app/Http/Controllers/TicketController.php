<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = Ticket::paginate(5);
        $page = $tickets->currentPage();
        return view('admin.ticket.tickets', compact('tickets','page'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page = request()->query('page');
        return view('admin.ticket.CreateTicket',compact('page'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Ticket::create([
            'trip_id' => $request->input('trip_id'),
            'seat_id' => $request->input('seat'),
            'user_id' => $request->input('user_id'),
        ]);
        return redirect()->route('admin.tickets.index')->with('success', 'Билет успешно добавлен');
    }
}
