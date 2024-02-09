<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCarriageRequest;
use App\Http\Requests\EditCarriageRequest;
use App\Models\Train;
use App\Models\TrainCarriage;
use Illuminate\Http\Request;

class TrainCarriageController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index($train_id)
    {
        $pageTransports = request()->query('page');
        $train = Train::find($train_id);
        $carriages = TrainCarriage::where('train_id', $train_id)->paginate(5);
        return view('admin.TrainCarriages', compact('carriages','train','pageTransports'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(TrainCarriage $carriage, $train_id)
    {
        $page = request()->query('page');
        $train = Train::find($train_id);
        return view('admin.CreateTrainCarriage', compact('carriage','train'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCarriageRequest $request, $train_id)
    {
        TrainCarriage::create([
            'train_id' => $train_id,
            'number' => $request->input('number'),
            'type' => $request->input('type')
        ]);
        // Редирект с сообщением об успешном добавлении
        return redirect()->route('admin.transports.index')->with('success', 'Вагон успешно добавлен');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($train_id, TrainCarriage $carriage)
    {
        $type = Train::find($train_id)->type;
        return view('admin.EditCarriage', compact('carriage','train_id','type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditCarriageRequest $request, $train_id, TrainCarriage $carriage)
    {
        $carriage->update([
            'seat_number' => $request->input('number'),
            'type' => $request->input('type')
        ]);

        // Редирект с сообщением об успешном обновлении
            return redirect()->route('admin.transports.train.index',['train_id' => $train_id])->with('success', 'Вагон успешно обновлен');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($train_id, TrainCarriage $carriage)
    {
        $carriage->delete();
        return redirect()->route('admin.transports.train.index',['train_id' => $train_id])->with('success', 'Вагон успешно удален');
    }
}
