<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Validator;

use App\Access;

// User controller
class UserController extends Controller
{
    public function login(){ 
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
                $user = Auth::user(); 
                $success['token'] =  $user->createToken('MyApp')->accessToken; 
                return response()->json(['success' => $success], 200);
            } 
            else{ 
                return response()->json(['error'=>'Email or Password is invalid'], 401); 
            }    
    }

    public function adminLogin(){
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $email = request('email');
            $isAdmin = User::select('isAdmin')->where('email','=', $email)->get();
            if ($isAdmin[0]->isAdmin == 'YES'){
                $user = Auth::user(); 
                $success['token'] =  $user->createToken('MyApp')-> accessToken; 
                return response()->json(['success' => $success], 200);
            }
            else{
                return response()->json(['error'=> 'Not Admin'], 401);
            }
        } 
        else{ 
            return response()->json(['error'=> 'Unauthorized'], 401); 

        }    
    }

    public function index()
    {
        $user = User::all();
        
        return response()->json($user, 200);
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
            'email' => 'required|min:3',
            'password' => 'required|min:8',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json($validator->errors(), 404);
        }
        $user = User::create($request->all());
        return response()->json($user, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        if(is_null($user)){
            return response()->json(["message" => "Record Not Found"], 404);
        }
        return response()->json($user, 200);
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
        $user = User::find($id);
        if(is_null($user)){
            return response()->json(["message" => "Record Not Found"], 404);
        }
        $user->update($request->all());
        return response()->json($user, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if(is_null($user)){
            return response()->json(["message" => "Record Not Found"], 404);
        }
        $user->delete();
        return response()->json(null, 204);
    }

    public function logout(Request $request)
    {
        $token = request('token');
        if(Auth::check() && Auth::user()->token() == $token){
            Auth::user()->token()->revoke();
        }
        Auth::logout();
        return response()->json([
            'message' =>  'Successfully log out'
        ]);
    }
}

