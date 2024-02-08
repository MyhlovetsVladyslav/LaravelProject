<?php

namespace App\Http\Controllers;

use App\Models\BusRoutes;
use App\Models\PlaneRoutes;
use App\Models\Route;
use App\Models\TrainRoutes;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $routes = Route::paginate(5);

        return view('admin.routes', compact('routes'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.CreateRoute');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $route = match ($request->input('type')) {
            'bus' => BusRoutes::create([
                'departure_location' => $request->input('departure_location'),
                'arrival_location' => $request->input('arrival_location'),
                'distance' => $request->input('distance'),
                'duration' => $request->input('duration')
            ]),
            'train' => TrainRoutes::create([
                'departure_location' => $request->input('departure_location'),
                'arrival_location' => $request->input('arrival_location'),
                'distance' => $request->input('distance'),
                'duration' => $request->input('duration')
            ]),
            'plane' => PlaneRoutes::create([
                'departure_location' => $request->input('departure_location'),
                'arrival_location' => $request->input('arrival_location'),
                'distance' => $request->input('distance'),
                'duration' => $request->input('duration')
            ]),
            default => null,
        };

        $routation = new Route;
        $routation->type = $request->input('type');
        $routation->routable()->associate($route);
        $routation->save();

        // Редирект с сообщением об успешном добавлении
        return redirect()->route('admin.routes.index')->with('success', 'Маршрут успешно добавлен');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Route $route)
    {
        return view('admin.EditRoute', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request  $request, Route $route)
    {
        if ($route->routable) {
            $route->routable->update([
                'departure_location' => $request->input('departure_location'),
                'arrival_location' => $request->input('arrival_location'),
                'distance' => $request->input('distance'),
                'duration' => $request->input('duration')
            ]);

            // Редирект с сообщением об успешном обновлении
            return redirect()->route('admin.routes.index')->with('success', 'Маршрут успешно обновлен');
        }

        return redirect()->route('admin.routes.index')->with('error', 'Связанная модель routable не существует');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Route $route)
    {
        $route->delete();
        return redirect()->route('admin.routes.index')->with('success', 'Маршрут успешно удален');
    }
}
