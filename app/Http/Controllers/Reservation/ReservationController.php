<?php

namespace App\Http\Controllers\Reservation;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ReservationModel;
use Validator;

class ReservationController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reservation = ReservationModel::all();
        
        return response()->json($reservation, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required',
            'phoneNo' => 'required',
            'venue' => 'required',
            'dateTime' => 'required',
            'description' => 'required|min:8'
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json($validator->errors(), 404);
        }
        $reservation = ReservationModel::create($request->all());
        return response()->json($reservation, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $reservation = ReservationModel::find($id);
        if(is_null($reservation)){
            return response()->json(["message" => "Record Not Found"], 404);
        }
        return response()->json($reservation, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $reservation = ReservationModel::find($id);
        if(is_null($reservation)){
            return response()->json(["message" => "Record Not Found"], 404);
        }
        $reservation->update($request->all());
        return response()->json($reservation, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reservation = ReservationModel::find($id);
        if(is_null($reservation)){
            return response()->json(["message" => "Record Not Found"], 404);
        }
        $reservation->delete();
        return response()->json(null, 204);
    }
}
