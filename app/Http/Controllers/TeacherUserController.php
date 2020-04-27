<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

//Models
Use App\Models\TeacherUser;

// Resources
Use App\Http\Resources\TeacherUser as TeacherUserResource;
Use App\Http\Resources\TeacherUserCollection as TeacherUserCollectionResource;

// Helpers
use Illuminate\Support\Str;

class TeacherUserController extends Controller
{
    public function index() {
        return new TeacherUserCollectionResource(TeacherUser::with(['questions'])->get());
    }

    public function store(Request $req) {
        // Validação de dados
        $validator = Validator::make($req->all(), [
            'cpf' => 'required|unique:teacher_users|max:11',
            'name' => 'required|string|max:255'
        ]);
        if($validator->fails()) return response($validator->errors(), 400);

        // Verificando se o usuário é válido na base do SIGEDUC
        // Implementar código
        
        
    }

    public function show($id) {
        $grade = Grade::with(['subjects'])->find($id);
        
        if(!$grade) return response(['error' => 'Item not found.'], 404);

        return new GradeResource($grade);
    }

    public function update($id, Request $req) {
        // Validação de dados
        $validator = Validator::make($req->all(), [
            'name' => 'required|string|max:255'
        ]);

        if($validator->fails()) return response($validator->errors(), 400);

        // Verificando se o item existe no DB
        $grade = Grade::find($id);
        if(!$grade) return response(['error' => 'Item not found'], 404);

        // Gerando slug
        $slug = Str::slug($req->name, '-');

        // Verificando se já existe um item cadastrado com o mesmo nome
        $gradeExists = Grade::where('slug', $slug)->first();
        if($gradeExists) return response(['error' => 'Item already exists.'], 400);

        // Atualizando item
        $grade->name = $req->name;
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
