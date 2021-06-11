<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function create(Request $request){
        $user = new User();
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->email_verified_at = now();
        $user->password = Hash::make($request->get('password'));
        $user->save();

        $token = $user->createToken($request->token_name);

        return response()->json( ['token' => $token->plainTextToken], Response::HTTP_OK);
    }
}
