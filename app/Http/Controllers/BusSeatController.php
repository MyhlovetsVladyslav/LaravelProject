<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBusSeatRequest;
use App\Http\Requests\EditBusSeatRequest;
use App\Models\Bus;
use App\Models\BusSeat;
use App\Models\Seat;
use Illuminate\Http\Request;

class BusSeatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($bus_id)
    {
        $seats = BusSeat::where('bus_id', $bus_id)->paginate(5);
        $bus_number = Bus::find($bus_id)->number;
        return view('admin.BusSeat', compact('seats','bus_number', 'bus_id'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($bus_id)
    {
        return view('admin.CreateBusSeat', compact('bus_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateBusSeatRequest $request, $bus_id)
    {
        $seat = BusSeat::create([
            'bus_id' => $bus_id,
            'seat_number' => $request->input('seat_number'),
        ]);
        $seatable = new Seat;
        $seatable->seatable()->associate($seat);
        $seatable->save();
        // Редирект с сообщением об успешном добавлении
        return redirect()->route('admin.transports.index')->with('success', 'Место успешно добавлено');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($bus_id , BusSeat $seat)
    {
        return view('admin.EditBusSeat', compact('seat','bus_id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditBusSeatRequest $request, $bus_id, BusSeat $seat)
    {
        $seat->update([
            'seat_number' => $request->input('seat_number'),
        ]);

        // Редирект с сообщением об успешном обновлении
        return redirect()->route('admin.transports.bus.index',['bus_id' => $bus_id])->with('success', 'Место успешно обновлено');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($bus_id, BusSeat $seat)
    {
        $seat->delete();
        return redirect()->route('admin.transports.bus.index',['bus_id' => $bus_id])->with('success', 'Место успешно удалено');
    }
}
