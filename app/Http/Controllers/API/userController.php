<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Validator;
use Illuminate\Support\Facades\Auth; 
class userController extends Controller
{
    public function login(Request $req) 
    {
		if(Auth::attempt(['number' => request('number'), 'password' => request('password')])){ 
            $user = Auth::User(); 
            $success['token'] =  $user->createToken('tfran')-> accessToken; 
            $userApp = new User;
            $type= $userApp::where('number',request('number'))->value('type');
            return response()->json(['success' => $success,'type' => $type], 200); 
        } 
        else{ 
            return response()->json(['error'=>'Unauthorised'], 401); 
        }
    }

    public function reg(Request $req) 
    {
    	$validator = Validator::make($req->all(), [ 
            'name' => 'required', 
            'number' => 'required|unique:users', 
            'password' => 'required', 
        ]);

        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $input = $req->all(); 

        $input['password'] = bcrypt($input['password']);

         $user =  User::create([
            'name' => $input['name'],
            'number' => $input['number'],
            'password' => $input['password'],
            'type' => 0,
        ]);

        $success['token'] =  $user->createToken('smart')-> accessToken; 
        $success['name'] =  $user->name;
        return response()->json(['success'=>$success], 200); 
    }

    public function details()
    {
        return response()->json(Auth::User());
    }
}
