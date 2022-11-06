<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $user->save();

        return response()->json([
            'status' => 1,
            'msg' => 'Registro de usuario exito!',

        ]);
    }
    
    public function login(Request $request){
        $request->validate([
            'email'=>'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', '=', $request->email)->first();

        if( isset($user->id)){
            if(Hash::check($request->password, $user->password)){
                // creamos el hash
                $token = $user->createToken('auth_token')->plainTextToken;
                //si esta todo ok
                return response()->json([
                    'status' => 1,
                    'msg' => 'El usuario logueado existosamente',
                    'access_token' => $token
                ]);
            }else{
                return response()->json([
                    'status' => 0,
                    'msg' => 'La contraseña es incorrecta',
                ], 404);
            }
        }else{
            return response()->json([
                'status' => 0,
                'msg' => 'El usuario no registrado',
            ], 404);
        }
    }
    
    public function userProfile(){
        return response()->json([
            'status' => 0,
            'msg' => 'Acerca del perfil de usuario',
            'data' => auth()->user()
        ]);
    }
    
    public function logout(){
        auth()->user()->tokens()->delete();

        return response()->json([
            'status' => 1,
            'msg' => 'Cierre de Sesion'
        ]);
    }
}
