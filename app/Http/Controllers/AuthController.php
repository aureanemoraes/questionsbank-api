<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// Validator
use Validator;
// Models
use App\Models\User;


class AuthController extends Controller
{
    // Criando usuário
    public function signup(Request $req) {
        $validator = Validator::make($req->all(), [
            'cpf' => 'required|unique:users|max:11',
            'name' => 'required|string|max:255',
            'email' => 'required|string|unique:users|max:255',
            'password' => 'required|min:6|max:20',
            'password_confirmation' => 'required|same:password'
        ]);
        if($validator->fails()) return response($validator->errors());

        $inputs = $req->all();
        $inputs['password'] = bcrypt($req->password);
        $newUser = User::create($inputs);

        if($newUser) {
            $success['token'] = $newUser->createToken('token')->accessToken;
            $success['msg'] = 'Registration successfull.';
            return response($success);
        } else {
            $error['error'] = "Registration failed.";
            return response($error, 401);
        }
    }

    public function login(Request $req) {
        $validator = Validator::make($req->all(),[
            'cpf' => 'required|string|max:11',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return response($validator->errors());
        }

        $credentials = $req->all();
        if(!Auth::attempt($credentials)) {
            $error['error'] = 'Unhauthorized.';
            return response($error, 401);
        }
        $user = $req->user();
        $success['token'] = $user->createToken('token')->accessToken;
        $success['user'] = $req->user();
        return response($success);
    }

    public function logout(Request $req) {
        $isLogged = $req->user()->token()->revoke();
        if($isLogged) {
            $success['msg'] = 'Successfully logged out.';
            return response($success);
        } else {
            $error['error'] = 'Something went wrong.';
            return response($error);
        }
    }
}
