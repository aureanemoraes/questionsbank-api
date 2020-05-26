<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

//Models
Use App\Models\QuestionLevel;

// Resources
Use App\Http\Resources\QuestionLevel as QuestionLevelResource;
Use App\Http\Resources\QuestionLevelCollection as QuestionLevelCollectionResource;

// Helpers
use Illuminate\Support\Str;

class QuestionLevelController extends Controller
{
    public function index() {
        return new QuestionLevelCollectionResource(QuestionLevel::with(['questions'])->get());
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
        $questionLevel = QuestionLevel::where('slug', $slug)->first();
        if ($questionLevel) return response(['error' => 'Item already registered.'], 400);

        // Criando item
        return new QuestionLevelResource(QuestionLevel::create([
            'name' => $req->name,
            'slug' => $slug
        ]));
    }

    public function show($id) {
        $questionLevel = QuestionLevel::with(['questions'])->find($id);

        if(!$questionLevel) return response(['error' => 'Item not found.'], 404);

        return new QuestionLevelResource($questionLevel);
    }

    public function update($id, Request $req) {
        // Validação de dados
        $validator = Validator::make($req->all(), [
            'name' => 'required|string|max:255'
        ]);
        if($validator->fails()) return response($validator->errors(), 400);

        // Verificando se o item existe no DB
        $questionLevel = QuestionLevel::find($id);

        if(!$questionLevel) return response(['error' => 'Item not found'], 404);
        // Gerando slug
        $slug = Str::slug($req->name, '-');

        // Verificando se já existe um item cadastrado com o mesmo nome
        $questionLevelExists = QuestionLevel::where('slug', $slug)->first();
        if($questionLevelExists) return response(['error' => 'Item already exists.'], 400);

        // Atualizando item
        $questionLevel->name = $req->name;
        $questionLevel->slug = $slug;
        $questionLevel->save();

        return new QuestionLevelResource($questionLevel);
    }

    public function destroy($id) {
        // Verificando se o item existe no DB
        $questionLevel = QuestionLevel::find($id);
        if(!$questionLevel) return response(['error' => 'Item not found'], 404);

        // Deletando item
        $questionLevel->delete();
        return response('', 204);
    }

    public function indexToOption() {
        return new QuestionLevelCollectionResource(
            QuestionLevel::select('id', 'name')->get()
        );
    }
}
