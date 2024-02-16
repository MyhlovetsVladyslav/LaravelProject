<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\TrainCarriage;
use App\Models\Transport;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function searchRoutes(Request $request)
    {
        $text = $request->input('text');
        $type = $request->input('type');

        $events = Route::where('type', $type)
            ->whereHas('routable', function($query) use ($text) {
                $query->where('departure_location', 'like', '%' . $text . '%')
                    ->orWhere('arrival_location', 'like', '%' . $text . '%');
            })
            ->with('routable')
            ->get();
        return response()->json($events);
    }

    public function searchTransports(Request $request)
    {
        $text = $request->input('text');
        $type = $request->input('type');

        $events = Transport::where('type', $type)
            ->whereHas('transportable', function($query) use ($text) {
                $query->where('number', 'like', '%' . $text . '%');
            })
            ->with('transportable')
            ->get();



        return response()->json($events);
    }

    public function searchTrip(Request $request)
    {
        $type = $request->input('type');
        $text = $request->input('text');

        $events = Trip::where('departure_time', '>', now()->setTimezone('Europe/Minsk'))->whereHas('route', function ($query) use ($type, $text) {
            $query->where('type', $type)
                ->whereHas('routable', function ($query) use ($text) {
                    $query->where('departure_location', 'like', '%' . $text . '%')
                        ->orWhere('arrival_location', 'like', '%' . $text . '%');
                });
        })->whereHas('transport', function ($query) use ($type) {
            $query->where('type', $type)
                ->whereHas('transportable',function ($query){
                    $query->whereHas('seats', function ($query){
                        $query->whereHas('seat');
                    });
                });
        })->with(['route.routable', 'transport.transportable','transport.transportable.seats','transport.transportable.seats.seat'])->get();
        return response()->json($events);
    }

    public function searchUser(Request $request)
    {
        $text = $request->input('text');
        $events = User::where('name','like', '%' . $text . '%')
            ->get();
        return response()->json($events);
    }
}
