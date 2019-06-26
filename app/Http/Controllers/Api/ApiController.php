<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class ApiController extends Controller
{

    public function userAuthenticate(Request $request) {
        $email = $request->email;
        $password = $request->password;

        if (Auth::attempt(['email' => $email, 'password' => $password]))
        {
            if(isset(auth()->user()->roles[0]->name) && auth()->user()->roles[0]->name == 'Technician/SubContractor'){
                return response()->json([
                    'status' => 200,
                    'response' => 'Succesfully Logged In',
                    'userId' => auth()->user()->id
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'response' => 'Unable to login'
                ]);
            }
        } else {
            return response()->json([
                'status' => 404,
                'response' => 'Credentials do not match'
            ]);
        }
    }
}
