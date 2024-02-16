<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchBusApiRequest;
use App\Http\Requests\SearchPlaneApiReqest;
use App\Http\Requests\SearchTrainApiReqest;
use App\Http\Resources\SearchBusResource;
use App\Http\Resources\SearchTrainResource;
use App\Models\TrainCarriage;
use App\Models\TrainSeat;
use App\Models\Trip;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function searchBus(SearchBusApiRequest $request)
    {
        $departure_location = $request->input('departure');
        $arrival_location = $request->input('arrival');
        $departure_time = $request->input('date');
        $events = Trip::where('departure_time', 'like', '%' . $departure_time . '%')
            ->whereHas('route', function ($query) use ($departure_location, $arrival_location) {
                $query->where('type', 'bus')
                    ->whereHas('routable', function ($query) use ($departure_location, $arrival_location) {
                        $query->where('departure_location', 'like', '%' . $departure_location . '%')
                            ->orWhere('arrival_location', 'like', '%' . $arrival_location . '%');
                    });
            })
            ->whereHas('transport', function ($query) {
                $query->where('type', 'bus')
                    ->whereHas('transportable', function ($query) {
                        $query->whereHas('seats', function ($query) {
                           $query->whereHas('seat',function ($query){
                               $query->whereHas('tickets');
                           });
                        });
                    });
            })
            ->with(['route', 'route.routable', 'transport', 'transport.transportable','transport.transportable.seats','transport.transportable.seats.seat'])
            ->get();


        return [
            'events' => SearchBusResource::collection($events)
        ];
    }
    public function searchTrain(SearchTrainApiReqest $request)
    {

        $departure_location = $request->input('departure');
        $arrival_location = $request->input('arrival');
        $departure_time = $request->input('date');
        $events = Trip::where('departure_time', 'like', '%' . $departure_time . '%')
            ->whereHas('route', function ($query) use ($departure_location, $arrival_location) {
                $query->where('type', 'train')
                    ->whereHas('routable', function ($query) use ($departure_location, $arrival_location) {
                        $query->where('departure_location', 'like', '%' . $departure_location . '%')
                            ->orWhere('arrival_location', 'like', '%' . $arrival_location . '%');
                    });
            })
            ->whereHas('transport', function ($query) {
                $query->where('type', 'train')
                    ->whereHas('transportable', function ($query) {
                        $query->whereHas('seats', function ($query) {
                            $query->whereHas('seat');
                        });
                    });
            })
            ->with(['route', 'route.routable', 'transport', 'transport.transportable','transport.transportable.seats','transport.transportable.seats.seat'])
            ->get();

        return [
            'events' => /*SearchTrainResource::collection($events)*/ $events,
        ];
    }
    public function searchPlane(SearchPlaneApiReqest $request)
    {
        $departure_location = $request->input('departure');
        $arrival_location = $request->input('arrival');
        $departure_time = $request->input('date');
        $events = Trip::where('departure_time', 'like', '%' . $departure_time . '%')
            ->whereHas('route', function ($query) use ($departure_location, $arrival_location) {
                $query->where('type', 'plane')
                    ->whereHas('routable', function ($query) use ($departure_location, $arrival_location) {
                        $query->where('departure_location', 'like', '%' . $departure_location . '%')
                            ->orWhere('arrival_location', 'like', '%' . $arrival_location . '%');
                    });
            })
            ->whereHas('transport', function ($query) {
                $query->where('type', 'plane')
                    ->whereHas('transportable', function ($query) {
                        $query->whereHas('seats', function ($query) {
                            $query->whereHas('seat');
                        });
                    });
            })
            ->with(['route', 'route.routable', 'transport', 'transport.transportable','transport.transportable.seats','transport.transportable.seats.seat'])
            ->get();


        return response()->json($events);
    }
}
