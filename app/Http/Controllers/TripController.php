<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTripRequest;
use App\Models\Trip;
use App\Models\TripPrice;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TripController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trips = Trip::paginate(5);
        $page = $trips->currentPage();
        return view('admin.trip.trips', compact('trips','page'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page = request()->query('page');
        return view('admin.trip.CreateTrip', compact( 'page'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateTripRequest $request)
    {
        $tripTypes = [
            'bus' => ['type' => null, 'price' => $request->input('price_bus')],
            'train' => [
                'passenger' => [
                    ['type' => 'platskart', 'price' => $request->input('price_platskart')],
                    ['type' => 'coupe', 'price' => $request->input('price_coupe')],
                    ['type' => 'lux', 'price' => $request->input('price_lux')]
                ],
                'intercity' => [
                    ['type' => 'first_class', 'price' => $request->input('price_first_class')],
                    ['type' => 'second_class', 'price' => $request->input('price_second_class')]
                ]
            ],
            'plane' => [['type' => null, 'price' => $request->input('price_plane')]]
        ];
        $trip = Trip::create([
            'route_id' => explode('|', $request->input('route'))[0],
            'transport_id' => explode('|', $request->input('transport'))[0],
            'departure_time' => $request->input('date_departure'),
            'arrival_time' => $request->input('date_arrival'),
        ]);
        if ($request->input('type') === 'plane' || $request->input('type') === 'bus' ) {
            TripPrice::create([
                'trip_id' => $trip->id,
                'type' => $tripTypes[$request->input('type')]['type'],
                'price' => $tripTypes[$request->input('type')]['price']
            ]);
        } else {
            foreach ($tripTypes[$request->input('type')][$request->input('subType')] as $priceInfo) {
                TripPrice::create([
                    'trip_id' => $trip->id,
                    'type' => $priceInfo['type'],
                    'price' => $priceInfo['price']
                ]);
            }
        }
        $page = request()->query('page');
        return redirect()->route('admin.trips.index', ['page' => $page])->with('success', 'Рейс успешно добавлен');
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
