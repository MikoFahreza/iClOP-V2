<?php

namespace App\Http\Controllers\Postgre;

use App\Models\Postgre\Exercise;
use App\Models\Postgre\ExerciseQuestion;
use App\Models\Postgre\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ExerciseQuestionController extends Controller
{
    public function getExerciseQuestionDataTable()
    {
        $question = Question::all();

        return DataTables::of($question)
            ->addColumn('actions', function ($row) {
                return '<div class="btn-group" role="group">
            <button id="assignQuestionToExerciseBtn" type="button" class="btn btn-info btn-block" data-id="' . $row['id'] . '">
            <i class="fa fa-arrow-left"></i>
            </button> 
            </div>';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function getExerciseQuestionDataTableByExercise(Request $request)
    {
        // $question = Question::all();
        $question = DB::table('postgre_exercise_question')
            ->join('postgre_exercise', 'postgre_exercise_question.exercise_id', 'postgre_exercise.id')
            ->join('postgre_question', 'postgre_exercise_question.question_id', 'postgre_question.id')
            ->where('postgre_exercise_question.exercise_id', $request->exercise_id)
            ->where('postgre_exercise_question.isRemoved', '=', 0)
            ->select('postgre_exercise_question.id', 'postgre_question.title', 'postgre_question.sub_topic_id', 'postgre_exercise_question.no', 'postgre_question.id as question_id')
            ->orderBy('postgre_exercise_question.no')
            ->get();

        return DataTables::of($question)
            ->addColumn('actions', function ($row) {
                return '<div class="btn-group" role="group">
            <button id="removeQuestionFromExerciseBtn" type="button" class="btn btn-danger btn-block" data-id="' . $row->question_id . '">
            <i class="fa fa-arrow-right"></i>
            </button> 
            </div>';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function getExerciseIDForDataTable(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'class_id' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            return response()->json(['code' => 1, 'msg' => $request->class_id]);
        }
    }

    public function getExerciseQuestionList(Request $request)
    {
        $exercise_id = $request->exercise_id;
        $exercise = DB::table('postgre_exercise_question')
            ->join('postgre_exercise', 'postgre_exercise_question.exercise_id', 'postgre_exercise.id')
            ->join('postgre_question', 'postgre_exercise_question.question_id', 'postgre_question.id')
            ->join('postgre_sub_topic', 'postgre_question.sub_topic_id', 'postgre_sub_topic.id')
            ->join('postgre_topic', 'postgre_sub_topic.topic_id', 'postgre_topic.id')
            ->where('postgre_exercise_question.exercise_id', $exercise_id)
            ->select('postgre_question.title', 'postgre_question.sub_topic_id', 'postgre_sub_topic.name AS sub_topic_name', 'postgre_topic.name AS topic_name', 'postgre_question.title', 'postgre_question.description', 'postgre_exercise_question.exercise_id', 'postgre_exercise_question.no')
            ->get();

        return DataTables::of($exercise)
            ->addColumn('actions', function ($row) {
                $route = "question/" . $row->exercise_id . "/" . $row->no;
                return '<div class="btn-group" role="group">
            <a href="' . $route . '" class="btn btn-primary btn-block"><i class="fa fa-pen"></i></a> 
            </div>';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function getExerciseQuestionItem(Request $request)
    {
        $soal = DB::table('postgre_exercise_question')
            ->join('postgre_question', 'postgre_exercise_question.question_id', 'postgre_question.id')
            ->join('postgre_sub_topic', 'postgre_question.sub_topic_id', 'postgre_sub_topic.id')
            ->join('postgre_topic', 'postgre_sub_topic.topic_id', 'postgre_topic.id')
            ->where('postgre_exercise_question.exercise_id', '=', $request->exercise_id)
            ->where('postgre_exercise_question.no', '=', $request->question_no)
            ->select('postgre_exercise_question.no', 'postgre_question.id', 'postgre_question.title', 'postgre_question.sub_topic_id', 'postgre_question.dbname', 'postgre_question.description', 'postgre_question.required_table', 'postgre_question.test_code', 'postgre_question.guide', 'postgre_exercise_question.exercise_id')
            ->get();
        $jumlah_soal = ExerciseQuestion::where('exercise_id', '=', $request->exercise_id)->get()->count();
        return view('postgre.user.student.question.index', compact('soal', 'jumlah_soal'));
    }

    public function getExerciseQuestion(Request $request)
    {
        // $details = DB::table('exercise_question')
        //     ->join('exercise', 'exercise_question.exercise_id', 'exercise_id')
        //     ->join('question', 'exercise_question.question_id', 'question.id')
        //     ->where('exercise_question.exercise_id', $request->exercise_id)
        //     ->where('question.id', $request->question_id)
        //     ->select('question.id as question_id', 'exercise.id as exercise_id', 'exercise.name', 'question.title')
        //     ->get();

        $questionDetails = Question::where('id', $request->question_id)->get();
        $exerciseDetails = Exercise::where('id', $request->exercise_id)->get();
        return response()->json(['code' => 1, 'questionDetails' => $questionDetails, 'exerciseDetails' => $exerciseDetails]);
    }

    public function addExerciseQuestion(Request $request)
    {
        $result = ExerciseQuestion::updateOrCreate(
            ['exercise_id' => $request->eid, 'question_id' => $request->qid],
            ['exercise_id' => $request->eid, 'question_id' => $request->qid, 'no' => $request->no, 'isRemoved' => 0]
        );

        if ($result) {
            return response()->json(['code' => 1, 'msg' => 'Soal berhasil ditambahkan!']);
        } else {
            return response()->json(['code' => 0, 'msg' => 'Something went wrong']);
        }
    }

    public function removeExerciseQuestion(Request $request)
    {

        $question = ExerciseQuestion::updateOrCreate(
            ['exercise_id' => $request->exercise_id, 'question_id' => $request->question_id],
            ['isRemoved' => 1]
        );

        if (!$question) {
            return response()->json(['code' => 0, 'msg' => 'Terjadi kesalahan']);
        } else {
            return response()->json(['code' => 1, 'msg' => 'Soal berhasil dihapus']);
        }
    }
}