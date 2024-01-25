<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTransportRequest;
use App\Http\Requests\EditTransportRequest;
use Illuminate\Http\Request;
use App\Models\Transport;
use App\Models\Train;
use App\Models\Bus;
use App\Models\Plane;

class TransportController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transports = Transport::paginate(5);

        return view('admin.transports', compact('transports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Transport $transport)
    {
        return view('admin.CreateTransport', compact('transport'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateTransportRequest $request)
    {
        $transport = match ($request->input('type')) {
            'bus' => Bus::create([
                'number' => $request->input('number')
            ]),
            'train' => Train::create([
                'number' => $request->input('number'),
                'type' => $request->input('train_type')
            ]),
            'plane' => Plane::create([
                'number' => $request->input('number')
            ]),
            default => null,
        };

        $transportation = new Transport;
        $transportation->type = $request->input('type');
        $transportation->transportable()->associate($transport);
        $transportation->save();

        // Редирект с сообщением об успешном добавлении
        return redirect()->route('admin.transports.index')->with('success', 'Транспорт успешно добавлен');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transport $transport)
    {
        return view('admin.EditTransport', compact('transport'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditTransportRequest $request, Transport $transport)
    {
        $transport->update([
            'number' => $request->input('number'),
            'type' => $request->input('type'),
        ]);

        // Редирект с сообщением об успешном обновлении
        return redirect()->route('admin.transports.index', $transport)->with('success', 'Транспорт успешно обновлен');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transport $transport)
    {
        $transportType = Transport::with('transportable')->find($transport->id)->transportable;
        $transportType->delete();
        $transport->delete();
        return redirect()->route('admin.transports.index')->with('success', 'Транспорт успешно удален');
    }
}