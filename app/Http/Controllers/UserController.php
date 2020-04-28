<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

//Models
Use App\Models\User;

// Resources
Use App\Http\Resources\User as UserResource;
Use App\Http\Resources\UserCollection as UserCollectionResource;

// Helpers
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index() {
        return new UserCollectionResource(User::with(['questions'])->get());
    }

    public function store(Request $req) {
        // Validação de dados
        $validator = Validator::make($req->all(), [
            'cpf' => 'required|unique:users|max:11',
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'password' => 'required|min:6|max:20',
            'password_confirmation' => 'required'
        ]);
        if($validator->fails()) return response($validator->errors(), 400);

        // Verificando se o usuário é válido na base do SIGEDUC
        // Implementar código

        // Criando novo item
        return new UserResource(User::create([
            'cpf' => $req->cpf,
            'name' => $req->name,
            'email' => $req->email,
            'password' => $req->password
        ]));

    }

    public function show($cpf) {
        $user = User::with(['questions'])->find($cpf);

        if(!$user) return response(['error' => 'Item not found.'], 404);

        return new UserResource($user);
    }

    public function update($cpf, Request $req) {
        // Validação de dados
        $validator = Validator::make($req->all(), [
            'name' => 'required|string|max:255'
        ]);

        if($validator->fails()) return response($validator->errors(), 400);

        // Verificando se o item existe no DB
        $user = User::find($cpf);
        if(!$user) return response(['error' => 'Item not found'], 404);


        // Atualizando item
        $user->name = $req->name;
        $user->save();

        return new UserResource($user);

    }

    public function destroy($cpf) {
        // Verificando se o item existe no DB
        $user = User::find($cpf);
        if(!$user) return response(['error' => 'Item not found'], 404);

        // Deletando item
        $user->delete();
        return response('', 204);
    }
}
