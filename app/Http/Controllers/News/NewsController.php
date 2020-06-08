<?php

namespace App\Http\Controllers\News;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\NewsModel;
use Validator;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $new = NewsModel::all();
        return response()->json($new, 200);
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
            'title' => 'required',
            'paragraph' => 'required|min:8',
            'postDate' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json($validator->errors(), 404);
        }
        $new = NewsModel::create($request->all());
        return response()->json($new, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $new = NewsModel::find($id);
        if(is_null($new)){
            return response()->json(["message" => "Record Not Found"], 404);
        }
        return response()->json($new, 200);
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
        $new = NewsModel::find($id);
        if(is_null($new)){
            return response()->json(["message" => "Record Not Found"], 404);
        }
        $new->update($request->all());
        return response()->json($new, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $new = NewsModel::find($id);
        if(is_null($new)){
            return response()->json(["message" => "Record Not Found"], 404);
        }
        $new->delete();
        return response()->json(null, 204);
    }
}