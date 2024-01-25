<?php

namespace App\Http\Controllers;

use App\Models\TrainCarriage;
use App\Models\Transport;
use Illuminate\Http\Request;

class TrainCarriageController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trainCarriages = TrainCarriage::paginate(5);

        return view('admin.trains.carriages', compact('trainCarriages'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(TrainCarriage $carriage, $train_id, $train_type)
    {
        return view('admin.CreateTrainCarriage', compact('carriage','train_id','train_type'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $train_id)
    {
        TrainCarriage::create([
            'train_id' => $train_id,
            'number' => $request->input('number'),
            'type' => $request->input('type')
        ]);
        // Редирект с сообщением об успешном добавлении
        return redirect()->route('admin.transports.index')->with('success', 'Транспорт успешно добавлен');
    }
}
