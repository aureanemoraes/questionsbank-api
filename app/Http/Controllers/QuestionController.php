<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

//Models
Use App\Models\Question;
Use App\Models\AnswerType;
Use App\Models\QuestionLevel;
Use App\Models\User;
Use App\Models\Area;
Use App\Models\QuestionDescription;


// Resources
Use App\Http\Resources\Question as QuestionResource;
Use App\Http\Resources\QuestionCollection as QuestionCollectionResource;
Use App\Http\Resources\QuestionDescription as QuestionDescriptionResource;


class QuestionController extends Controller
{
    public function index() {
        return new QuestionCollectionResource(Question::with([
            'answerType',
            'questionDescription',
            'questionLevel',
            'teacher',
            'area'
        ])->get());
    }

    public function store(Request $req) {
        // Validação de dados
        $validator = Validator::make($req->all(), [
            'title' => 'required|string',
            'answer_type_id' => 'required|integer',
            'question_level_id' => 'required|integer',
            'area_id' => 'required|integer'
        ]);
        if($validator->fails()) return response($validator->errors(), 400);

        // Verificando se as FK são válidas
        $answerType = AnswerType::find($req->answer_type_id);
        $questionLevel = QuestionLevel::find($req->question_level_id);
        $area = Area::find($req->area_id);
        if(!($answerType && $questionLevel && $area))
            return response(['error' => 'Invalid entries.'], 400);

        // Criando novo item
        $question =  new QuestionResource(Question::create([
            'title' => $req->title,
            'answer_type_id' => $req->answer_type_id,
            'question_level_id' => $req->question_level_id,
            'teacher_id' => $req->user()->id,
            'area_id' => $req->area_id
        ]));

        // Verificando se há descrição e armazenando
        if($req->description){
            $description = new QuestionDescription([
                'description' => $req->description
            ]);
            $question->questionDescription()->save($description);
        }

        return new QuestionResource(Question::with([
            'answerType',
            'questionDescription',
            'questionLevel',
            'teacher',
            'area'
        ])->where('id', $question->id)->first());
    }

    public function show($id, Request $req) {
        $question = Question::with([
            'answerType',
            'questionDescription',
            'questionLevel',
            'teacher',
            'area'
        ])->find($id);

        if(!$question) return response(['error' => 'Item not found.'], 404);

        return new QuestionResource($question);
    }

    public function update($id, Request $req) {
        // Verificando se o item existe no DB
        $question = Question::find($id);
        if(!$question) return response(['error' => 'Item not found.'], 404);

        // Validação de dados
        $validator = Validator::make($req->all(), [
            'title' => 'required|string',
            'answer_type_id' => 'required|integer',
            'question_level_id' => 'required|integer',
            'area_id' => 'required|integer'
        ]);
        if($validator->fails()) return response($validator->errors(), 400);

        // Verificando se as FK são válidas
        $answerType = AnswerType::find($req->answer_type_id);
        $questionLevel = QuestionLevel::find($req->question_level_id);
        $area = Area::find($req->area_id);
        if(!($answerType && $questionLevel && $area))
            return response(['error' => 'Invalid entries.'], 400);

        // Atualizando item
        $question->title = $req->title;
        $question->answer_type_id = $req->answer_type_id;
        $question->question_level_id = $req->question_level_id;
        $question->teacher_id = $req->user()->cpf;
        $question->area_id = $req->area_id;
        $question->save();

        // Verificando se há descrição e armazenando
        if($req->description) {
            new QuestionDescriptionResource(QuestionDescription::updateOrCreate(
                    ['question_id' => $question->id],
                    ['description' => $req->description]
                ));
        } else {
            $question->questionDescription()->delete();
        }

        return new QuestionResource(Question::with([
            'answerType',
            'questionDescription',
            'questionLevel',
            'teacher',
            'area'
        ])->where('id', $question->id)->first());
    }

    public function destroy($id) {
        // Verificando se o item existe no DB
        $question = Question::find($id);
        if(!$question) return response(['error' => 'Item not found'], 404);

        // Deletando item
        $question->questionDescription()->delete();
        $question->delete();
        return response('', 204);
    }
}
