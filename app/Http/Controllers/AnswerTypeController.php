<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

//Models
Use App\Models\AnswerType;

// Resources
Use App\Http\Resources\AnswerType as AnswerTypeResource;
Use App\Http\Resources\AnswerTypeCollection as AnswerTypeCollectionResource;

// Helpers
use Illuminate\Support\Str;

class AnswerTypeController extends Controller
{
    public function index() {
        return new AnswerTypeCollectionResource(AnswerType::with(['questions'])->get());
    }

    public function store(Request $req) {
        // Validação de dados
        $validator = Validator::make($req->all(), [
            'name' => 'required|string|max:255'
        ]);
        if($validator->fails()) return response($validator->errors(), 400);

        // Gerando slug
        $slug = Str::slug($req->name, '-');

        // Verificando se o item existe no DB
        $answerType = AnswerType::where('slug', $slug)->first();
        if ($answerType) return response(['error' => 'Item already registered.'], 400);

        // Criando item
        return new AnswerTypeResource(AnswerType::create([
            'name' => $req->name,
            'slug' => $slug
        ]));
    }

    public function show($id) {
        $answerType = AnswerType::with(['questions'])->find($id);

        if(!$answerType) return response(['error' => 'Item not found.'], 404);

        return new AnswerTypeResource($answerType);
    }

    public function update($id, Request $req) {
        // Validação de dados
        $validator = Validator::make($req->all(), [
            'name' => 'required|string|max:255'
        ]);
        if($validator->fails()) return response($validator->errors(), 400);

        // Verificando se o item existe no DB
        $answerType = AnswerType::find($id);

        if(!$answerType) return response(['error' => 'Item not found'], 404);
        // Gerando slug
        $slug = Str::slug($req->name, '-');

        // Verificando se já existe um item cadastrado com o mesmo nome
        $answerTypeExists = AnswerType::where('slug', $slug)->first();
        if($answerTypeExists) return response(['error' => 'Item already exists.'], 400);

        // Atualizando item
        $answerType->name = $req->name;
        $answerType->slug = $slug;
        $answerType->save();

        return new AnswerTypeResource($answerType);
    }

    public function destroy($id) {
        // Verificando se o item existe no DB
        $answerType = AnswerType::find($id);
        if(!$answerType) return response(['error' => 'Item not found'], 404);

        // Deletando item
        $answerType->delete();
        return response('', 204);
    }
}
