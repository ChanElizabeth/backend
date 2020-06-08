<?php

namespace App\Http\Controllers\Complaint;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ComplaintModel;
use Validator;


class ComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $complaint = ComplaintModel::all();
        
        return response()->json($complaint, 200);
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
            'subject' => 'required|min:8',
            'complaint' => 'required|min:8',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json($validator->errors(), 404);
        }
        $complaint = ComplaintModel::create($request->all());
        return response()->json($complaint, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $complaint = ComplaintModel::find($id);
        if(is_null($complaint)){
            return response()->json(["message" => "Record Not Found"], 404);
        }
        return response()->json($complaint, 200);
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
        $complaint = ComplaintModel::find($id);
        if(is_null($complaint)){
            return response()->json(["message" => "Record Not Found"], 404);
        }
        $complaint->update($request->all());
        return response()->json($complaint, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $complaint = ComplaintModel::find($id);
        if(is_null($complaint)){
            return response()->json(["message" => "Record Not Found"], 404);
        }
        $complaint->delete();
        return response()->json(null, 204);
    }
}
