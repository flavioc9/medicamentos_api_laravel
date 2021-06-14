<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

/**
 * @group Gestão de utilizadores
 *
 * APIs para gerir utilizadores
 */
class UserController extends Controller
{

    /**
     * Cria um utilizador
     *
     * <aside class="notice">Devolve o token necessário para autenticação.</aside>
     *
     * @unauthenticated
     * @bodyParam name string required Nome do utilizador. Example: Zé Ninguém
     * @bodyParam email string required Email do utilizador. Example: ze.ninguém@mail.pt
     * @bodyParam password string required Nome do utilizador. Example: Test1234!
     * @bodyParam token_name string required Nome do token do utilizador. Example: super_token
     *
     * @response scenario=success status=201 {
     *    "token" : "5|aRBYbrDcc28xbtTxOHk4In7MbpjMuVyPthEmKpk7"
     * }
     * @response scenario="bad request" status=400 {
     *    "error" : [
     *          "field_name" : "error description"
     *    ]
     * }
     *
     */
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
