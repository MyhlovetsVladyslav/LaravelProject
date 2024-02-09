<?php

namespace App\Http\Controllers;

use App\Models\BusRoutes;
use App\Models\PlaneRoutes;
use App\Models\Route;
use App\Models\TrainRoutes;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function search(Request $request)
    {
        $text = $request->input('text');
        $type = $request->input('type');


        switch ($type) {
            case 'bus':
                $events = BusRoutes::where('departure_location', 'like', '%' . $text . '%')
                    ->orWhere('arrival_location', 'like', '%' . $text . '%')
                    ->get();
                break;
            case 'train':
                $events = TrainRoutes::where('departure_location', 'like', '%' . $text . '%')
                    ->orWhere('arrival_location', 'like', '%' . $text . '%')
                    ->get();
                break;
            case 'plane':
                $events = PlaneRoutes::where('departure_location', 'like', '%' . $text . '%')
                    ->orWhere('arrival_location', 'like', '%' . $text . '%')
                    ->get();
                break;
            default:
                $events = collect();
                break;
        }
        return response()->json($events);
    }
}
