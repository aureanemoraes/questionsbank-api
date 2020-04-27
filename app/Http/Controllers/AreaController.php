<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

// Models
use App\Models\Area;

// Resources
Use App\Http\Resources\Area as AreaResource;
Use App\Http\Resources\AreaCollection as AreaCollectionResource;

// Helpers
use Illuminate\Support\Str;

class AreaController extends Controller
{
    public function index() {
        return new AreaCollectionResource(Area::with(['topics', 'questions'])->get());
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
        $area = Area::where('slug', $slug)->first();
        if ($area) return response(['error' => 'Item already registered.'], 404);

        // Criando item
        return new AreaResource(Area::create([
            'name' => $req->name,
            'slug' => $slug
        ]));
    }

    public function show($id) {
        $area = Area::with(['topics', 'questions'])->find($id);
        
        if(!$area) return response(['error' => 'Item not found.'], 404);

        return new AreaResource($area);
    }

    public function update($id, Request $req) {
        // Validação de dados
        $validator = Validator::make($req->all(), [
            'name' => 'required|string|max:255'
        ]);

        if($validator->fails()) return response($validator->errors(), 400);

        // Verificando se o item existe no DB
        $area = Area::find($id);
        if(!$area) return response(['error' => 'Item not found.'], 404);

        // Gerando slug
        $slug = Str::slug($req->name, '-');

        // Verificando se já existe um item cadastrado com o mesmo nome
        $areaExists = Area::where('slug', $slug)->first();
        if($areaExists) return response(['error' => 'Item already exists.'], 400);

        // Atualizando item
        $area->name = $req->name;
        $area->slug = $slug;
        $area->save();

        return new AreaResource($area);
    }

    public function destroy($id) {
        // Verificando se o item existe no DB
        $area = Area::find($id);
        if(!$area) return response(['error' => 'Item not found'], 404);

        // Deletando item
        $area->delete();
        return response('', 204);
    }
}
