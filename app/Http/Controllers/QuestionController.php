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
Use App\Models\AreasQuestion;
Use App\Models\Topic;
Use App\Models\TopicsQuestion;
Use App\Models\QuestionDescription;
Use App\Models\Option;
Use App\Models\QuestionCorrectOption;


// Resources
Use App\Http\Resources\Question as QuestionResource;
Use App\Http\Resources\QuestionCollection as QuestionCollectionResource;
Use App\Http\Resources\QuestionDescription as QuestionDescriptionResource;
Use App\Http\Resources\Option as OptionResource;
Use App\Http\Resources\QuestionCorrectOption as QuestionCorrectOptionResource;




class QuestionController extends Controller
{
    public function index() {
        return new QuestionCollectionResource(Question::with([
            'answerType',
            'description',
            'questionLevel',
            'teacher',
            'areas',
            'options',
            'topics'
        ])->get());
    }

    public function store(Request $req) {
        // Validação de dados
        $validator = Validator::make($req->all(), [
            'title' => 'required|string',
            'answer_type_id' => 'required|integer',
            'question_level_id' => 'required|integer',
            'areas_id' => 'array|required',
            'topics_id' => 'array|required',
            'optionsTitles' => 'array'
        ]);
        if($validator->fails()) return response($validator->errors(), 400);

        // Verificando se as FK são válidas
        $answerType = AnswerType::find($req->answer_type_id);
        $questionLevel = QuestionLevel::find($req->question_level_id);
        foreach($req->areas_id as $area_id) {
            if(Area::find($area_id)) {
                $areas = true;
            } else {
                $areas = false;
            }
        }
        foreach($req->topics_id as $topic_id) {
            if(Topic::find($topic_id)) {
                $topics = true;
            } else {
                $topics = false;
            }
        }
        if(!($answerType && $questionLevel && $areas && $topics))
            return response(['error' => 'Invalid entries.'], 400);

        // Criando novo item
        $question =  new QuestionResource(Question::create([
            'title' => $req->title,
            'answer_type_id' => $req->answer_type_id,
            'question_level_id' => $req->question_level_id,
            'teacher_id' => $req->user()->id
        ]));

        // Armazenando areas_questions
        foreach($req->areas_id as $area_id) {
            $question->areas()->save(
                new AreasQuestion([
                    'question_id' => $question->id,
                    'area_id' => $area_id
                ])
            );
        }

        // Armazenando topics_questions
        foreach($req->topics_id as $topic_id) {
            $question->topics()->save(
                new TopicsQuestion([
                    'question_id' => $question->id,
                    'topic_id' => $topic_id
                ])
            );
        }

        // Verificando se o answerType é única escolha || múltipla escola
        if( $answerType->slug === 'unica-escolha' ||
            $answerType->slug === 'multipla-escolha' ) {
            // Criando as Options
            if(!($req->optionsTitles && $req->correctOption))
                return response(['error' => 'Invalid entries.'], 400);

            foreach($req->optionsTitles as $optionTitle) {
                $option = $question->options()->save(
                    new Option([
                        'title' => $optionTitle,
                        'question_id' => $question->id
                    ])
                );
                if($option->title === $req->correctOption) {
                    $correctOpion = $question->correctOption()->save(
                        new QuestionCorrectOption([
                            'question_id' => $question->id,
                            'option_id' => $option->id
                        ])
                    );
                }
            }
        }

        // Verificando se há descrição e armazenando
        if($req->description){
            $description = new QuestionDescription([
                'description' => $req->description
            ]);
            $question->description()->save($description);
        }

        return new QuestionResource(Question::with([
            'answerType',
            'description',
            'questionLevel',
            'teacher',
            'areas',
            'options',
            'correctOption',
            'topics'
        ])->where('id', $question->id)->first());
    }

    public function show($id, Request $req) {
        $question = Question::with([
            'answerType',
            'description',
            'questionLevel',
            'teacher',
            'areas'
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
            $question->description()->delete();
        }

        return new QuestionResource(Question::with([
            'answerType',
            'description',
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
        $question->description()->delete();
        $question->delete();
        return response('', 204);
    }
}
