<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

//Models
Use App\Models\Grade;
// Resources
Use App\Http\Resources\Grade as GradeResource;
Use App\Http\Resources\GradeCollection as GradeCollectionResource;

// Helpers
use Illuminate\Support\Str;

class GradeController extends Controller
{
    public function index() {
        return new GradeCollectionResource(Grade::with(['topics'])->get());
    }

    public function store(Request $req) {
        // Validação de dados
        $validator = Validator::make($req->all(), [
            'name' => 'required|string|max:255',
            'year' => 'required|integer|'
        ]);
        if($validator->fails()) return response($validator->errors(), 400);

        // Gerando slug
        $slug = Str::slug($req->name . '-' . $req->year, '-');

        // Verificando se o item existe no DB
        $grade = Grade::where('slug', $slug)->first();
        if ($grade) return response(['error' => 'Item already registered.'], 400);

        // Criando item
        return new GradeResource(Grade::create([
            'name' => $req->name,
            'year' => $req->year,
            'slug' => $slug
        ]));
    }

    public function show($id) {
        $grade = Grade::with(['topics'])->find($id);

        if(!$grade) return response(['error' => 'Item not found.'], 404);

        return new GradeResource($grade);
    }

    public function update($id, Request $req) {
        // Validação de dados
        $validator = Validator::make($req->all(), [
            'name' => 'required|string|max:255',
            'year' => 'required|integer|'
        ]);

        if($validator->fails()) return response($validator->errors(), 400);

        // Verificando se o item existe no DB
        $grade = Grade::find($id);
        if(!$grade) return response(['error' => 'Item not found'], 404);

        // Gerando slug
        $slug = Str::slug($req->name . '-' . $req->year, '-');

        // Verificando se já existe um item cadastrado com o mesmo nome
        $gradeExists = Grade::where('slug', $slug)->first();
        if($gradeExists) return response(['error' => 'Item already exists.'], 400);

        // Atualizando item
        $grade->name = $req->name;
        $grade->year = $req->year;
        $grade->slug = $slug;
        $grade->save();

        return new GradeResource($grade);

    }

    public function destroy($id) {
        // Verificando se o item existe no DB
        $grade = Grade::find($id);
        if(!$grade) return response(['error' => 'Item not found'], 404);

        // Deletando item
        $grade->delete();
        return response('', 204);
    }

}
