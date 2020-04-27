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
        return new SubjectCollectionResource(Subject::with(['grade', 'topics'])->get());
    }

    public function store(Request $req) {
        // Validação de dados
        $validator = Validator::make($req->all(), [
            'name' => 'required|string|max:255',
            'grade_id' => 'required|integer'
        ]);
        if($validator->fails()) return response($validator->errors(), 400);

        // Verificando se as FK são válidas
        $grade = Grade::find($req->grade_id);
        if(!$grade) return response(['error' => 'Invalid entries'], 404);

        // Gerando slug
        $slug = Str::slug($req->name, '-');

        // Verificando se o item existe no DB
        $subject = Subject::where('slug', $slug)->first();
        if ($subject) return response(['error' => 'Item already registered.'], 400);

        // Criando item
        return new SubjectResource(Subject::create([
            'name' => $req->name,
            'grade_id' => $req->grade_id,
            'slug' => $slug
        ]));
    }

    public function show($id) {
        $subject = Subject::with(['grade', 'topics'])->find($id);
        
        if(!$subject) return response(['error' => 'Item not found.'], 404);

        return new SubjectResource($subject);
    }

    public function update($id, Request $req) {
        // Validação de dados
        $validator = Validator::make($req->all(), [
            'name' => 'required|string|max:255',
            'grade_id' => 'required|integer'
        ]);
        if($validator->fails()) return response($validator->errors(), 400);

        // Verificando se o item existe no DB
        $subject = Subject::find($id);
        if(!$subject) return response(['error' => 'Item not found'], 404);

        // Verificando se as FK são válidas
        $grade = Grade::find($req->grade_id);
        if(!$grade) return response(['error' => 'Invalid entries'], 404);

        // Gerando slug
        $slug = Str::slug($req->name, '-');

        // Verificando se já existe um item cadastrado com o mesmo nome
        $subjectExists = Subject::where('slug', $slug)->first();
        if($subjectExists) return response(['error' => 'Item already exists.'], 400);

        // Atualizando item
        $subject->name = $req->name;
        $subject->grade_id = $req->grade_id;
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
