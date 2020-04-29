<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

//Models
Use App\Models\Topic;
Use App\Models\Subject;
Use App\Models\Area;
Use App\Models\Grade;

// Resources
Use App\Http\Resources\Topic as TopicResource;
Use App\Http\Resources\TopicCollection as TopicCollectionResource;

// Helpers
use Illuminate\Support\Str;

class TopicController extends Controller
{
    public function index() {
        return new TopicCollectionResource(Topic::with([
            'subject',
            'area',
            'grade'
        ])->get());
    }

    public function store(Request $req){
        // Validação de dados
        $validator = Validator::make($req->all(), [
            'name' => 'required|string|max:255',
            'subject_id' => 'required|integer',
            'area_id' => 'required|integer',
            'grade_id' => 'required|integer'
        ]);
        if($validator->fails()) return response($validator->errors(), 400);

        // Verificando se as FK são válidas
        $subject = Subject::find($req->subject_id);
        $area = Area::find($req->area_id);
        $grade = Grade::find($req->grade_id);
        if(!($subject && $area && $grade)) return response(['error' => 'Invalid entries'], 404);

        // Gerando slug
        $slug = Str::slug($req->name, '-');

        // Verificando se o item existe no DB
        $topic = Topic::where('slug', $slug)->first();
        if ($topic) return response(['error' => 'Item already registered.'], 404);

        // Criando item
        return new TopicResource(Topic::create([
            'name' => $req->name,
            'subject_id' => $req->subject_id,
            'area_id' => $req->area_id,
            'grade_id' => $req->grade_id,
            'slug' => $slug,
        ]));
    }

    public function show($id) {
        $topic = Topic::with(['subject', 'area', 'grade'])->find($id);

        if(!$topic) return response(['error' => 'Item not found.'], 404);

        return new TopicResource($topic);
    }

    public function update($id, Request $req) {
        // Validação de dados
        $validator = Validator::make($req->all(), [
            'name' => 'required|string|max:255',
            'subject_id' => 'required|integer',
            'area_id' => 'required|integer',
            'grade_id' => 'required|integer'
        ]);
        if($validator->fails()) return response($validator->errors(), 400);

        // Verificando se o item existe no DB
        $topic = Topic::find($id);
        if(!$topic) return response(['error' => 'Item not found'], 404);

        // Verificando se as FK são válidas
        $subject = Subject::find($req->subject_id);
        $area = Area::find($req->area_id);
        $grade = Grade::find($req->grade_id);
        if(!($subject && $area && $grade)) return response(['error' =>'Invalid entries'], 404);

        // Gerando slug
        $slug = Str::slug($req->name, '-');

        // Verificando se já existe um item cadastrado com o mesmo nome
        $topicExists = Topic::where('slug', $slug)->first();
        if($topicExists) return response(['error' => 'Item already exists.'], 400);

        // Atualizando item
        $topic->name = $req->name;
        $topic->subject_id = $req->subject_id;
        $topic->area_id = $req->area_id;
        $topic->grade_id = $req->grade_id;
        $topic->slug = $slug;
        $topic->save();

        return new TopicResource($topic);

    }

    public function destroy($id) {
        // Verificando se o item existe no DB
        $topic = Topic::find($id);
        if(!$topic) return response(['error' => 'Item not found'], 404);

        // Deletando item
        $topic->delete();
        return response('', 204);
    }

}
