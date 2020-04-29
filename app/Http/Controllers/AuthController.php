<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// Validator
use Validator;
// Models
use App\Models\User;
// Herdando AuthResponseController
use App\Http\Controllers\AuthResponseController as AuthResponseController;


class AuthController extends AuthResponseController
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
        if($validator->fails()) return $this->sendError($validator->errors());

        $inputs = $req->all();
        $inputs['password'] = bcrypt($req->password);
        $newUser = User::create($inputs);

        if($newUser) {
            $success['token'] = $newUser->createToken('token')->accessToken;
            $success['msg'] = 'Registration successfull.';
            return $this->sendResponse($success);
        } else {
            $error = "Registration failed.";
            return $this->sendError($error, 401);
        }
    }

    public function login(Request $req) {
        $validator = Validator::make($req->all(),[
            'cpf' => 'required|string|max:11',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());
        }

        $credentials = $req->all();
        if(!Auth::attempt($credentials)) {
            $error = 'Unhauthorized.';
            return $this->sendError($error, 401);
        }
        $user = $req->user();
        $success['token'] = $user->createToken('token')->accessToken;
        return $this->sendResponse($success);
    }

    public function logout(Request $req) {
        $isLogged = $req->user()->token()->revoke();
        if($isLogged) {
            $success['msg'] = 'Successfully logged out.';
            return $this->sendResponse($success);
        } else {
            $error = 'Something went wrong.';
            return $this->sendResponse($error);
        }
    }
}
