<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTrainSeatRequest;
use App\Http\Requests\EditTrainSeatRequest;
use App\Models\Seat;
use App\Models\TrainCarriage;
use App\Models\TrainSeat;
use Illuminate\Http\Request;

class TrainSeatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($train_id, $carriage_id)
    {

        $seats = TrainSeat::where('carriage_id', $carriage_id)->paginate(5);
        $carriage_number = TrainCarriage::where('id', $carriage_id)->value('number');
        return view('admin.TrainSeats', compact('seats', 'train_id', 'carriage_id', 'carriage_number'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(TrainSeat $seat, $train_id, $carriage_id)
    {
        return view('admin.CreateTrainSeat', compact('seat', 'train_id', 'carriage_id'));
    }


    public function store(CreateTrainSeatRequest $request, $train_id, $carriage_id)
    {
       $seat = TrainSeat::create([
            'carriage_id' => $carriage_id,
            'seat_number' => $request->input('seat_number'),
        ]);
        $seatable = new Seat;
        $seatable->seatable()->associate($seat);
        $seatable->save();
        // Редирект с сообщением об успешном добавлении
        return redirect()->route('admin.transports.train.index', ['train_id' => $train_id])->with('success', 'Место успешно добавлено');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($train_id, $carriage_id , TrainSeat $seat)
    {
        return view('admin.EditTrainSeats', compact('seat','train_id','carriage_id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditTrainSeatRequest $request, $train_id, $carriage_id, TrainSeat $seat)
    {
        $seat->update([
            'seat_number' => $request->input('seat_number'),
        ]);

        // Редирект с сообщением об успешном обновлении
        return redirect()->route('admin.transports.carriage.index',['train_id' => $train_id, 'carriage_id' => $carriage_id])->with('success', 'Место успешно обновлено');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($train_id, $carriage_id, TrainSeat $seat)
    {
        $seat->delete();
        return redirect()->route('admin.transports.carriage.index',['train_id' => $train_id, 'carriage_id' => $carriage_id])->with('success', 'Место успешно удалено');
    }
}
