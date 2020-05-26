<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

//Models
Use App\Models\Subject;
Use App\Models\Grade;


// Resources
Use App\Http\Resources\Subject as SubjectResource;
Use App\Http\Resources\SubjectCollection as SubjectCollectionResource;

// Helpers
use Illuminate\Support\Str;



class SubjectController extends Controller
{
    public function index() {
        return new SubjectCollectionResource(Subject::with(['topics', 'grades'])
        ->get());
    }

    public function store(Request $req) {
        // Validação de dados
        $validator = Validator::make($req->all(), [
            'name' => 'required|string|max:255'
        ]);
        if($validator->fails()) return response($validator->errors(), 400);

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

    public function indexToOptions($grade_id) {
        // receber o ID da GRADE
        // enviar somente as máterias com o grade_id == ID
        $subjects = Subject::where('grade_id', $grade_id)->get();

        return response($subjects);
    }
}
