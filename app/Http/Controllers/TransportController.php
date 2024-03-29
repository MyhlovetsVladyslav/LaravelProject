<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTransportRequest;
use App\Http\Requests\EditTransportRequest;
use App\Models\TrainCarriage;
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
        $page = $transports->currentPage();
        return view('admin.transports', compact('transports','page'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Transport $transport)
    {
        $page = request()->query('page');
        return view('admin.CreateTransport', compact('transport', 'page'));
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
        $page = request()->query('page');
        // Редирект с сообщением об успешном добавлении
        return redirect()->route('admin.transports.index', ['page' => $page])->with('success', 'Транспорт успешно добавлен');
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
        $page = request()->query('page');
        return view('admin.EditTransport', compact('transport','page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditTransportRequest  $request, Transport $transport)
    {
        $page = request()->query('page');
        if ($transport->transportable) {
            $transport->transportable->update([
                'number' => $request->input('number')
            ]);

            // Редирект с сообщением об успешном обновлении
            return redirect()->route('admin.transports.index', ['page' => $page])->with('success', 'Транспорт успешно обновлен');
        }

        // Если transportable не существует, выполните нужные действия (например, бросьте исключение или верните сообщение об ошибке)
        return redirect()->route('admin.transports.index', ['page' => $page])->with('error', 'Связанная модель transportable не существует');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transport $transport)
    {
        $page = request()->query('page');
        $transport->delete();
        return redirect()->route('admin.transports.index',['page' => $page])->with('success', 'Транспорт успешно удален');
    }
}
