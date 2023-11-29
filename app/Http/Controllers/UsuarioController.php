<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UsuarioRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credencias = $request->only(['email','password']);

        if(!$token = auth('api')->attempt($credencias)){
            return response()->json(["message" => "Email ou senha incorretos"],401);
        }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    public function create(UsuarioRequest $request)
    {
        $user = User::where("email",$request->email)->first();
        if($user)
        {
            return response()->json(["message" => "Usuário ja cadastrado com esse email"],409);
        }
        DB::beginTransaction();
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();
            DB::commit();

            return UserResource::make($user);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()],500);
        }

    }
}
