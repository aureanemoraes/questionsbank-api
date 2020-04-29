<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

//Models
Use App\Models\Subject;

// Resources
Use App\Http\Resources\Subject as SubjectResource;
Use App\Http\Resources\SubjectCollection as SubjectCollectionResource;

// Helpers
use Illuminate\Support\Str;



class SubjectController extends Controller
{
    public function index() {
        return new SubjectCollectionResource(Subject::with(['topics'])->get());
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
        $subject = Subject::where('slug', $slug)->first();
        if ($subject) return response(['error' => 'Item already registered.'], 400);

        // Criando item
        return new SubjectResource(Subject::create([
            'name' => $req->name,
            'slug' => $slug
        ]));
    }

    public function show($id) {
        $subject = Subject::with(['topics'])->find($id);

        if(!$subject) return response(['error' => 'Item not found.'], 404);

        return new SubjectResource($subject);
    }

    public function update($id, Request $req) {
        // Validação de dados
        $validator = Validator::make($req->all(), [
            'name' => 'required|string|max:255',
        ]);
        if($validator->fails()) return response($validator->errors(), 400);

        // Verificando se o item existe no DB
        $subject = Subject::find($id);
        if(!$subject) return response(['error' => 'Item not found'], 404);

        // Gerando slug
        $slug = Str::slug($req->name, '-');

        // Verificando se já existe um item cadastrado com o mesmo nome
        $subjectExists = Subject::where('slug', $slug)->first();
        if($subjectExists) return response(['error' => 'Item already exists.'], 400);

        // Atualizando item
        $subject->name = $req->name;
        $subject->slug = $slug;
        $subject->save();

        return new SubjectResource($subject);

    }

    public function destroy($id) {
        // Verificando se o item existe no DB
        $subject = Subject::find($id);
        if(!$subject) return response(['error' => 'Item not found'], 404);

        // Deletando item
        $subject->delete();
        return response('', 204);
    }
}
