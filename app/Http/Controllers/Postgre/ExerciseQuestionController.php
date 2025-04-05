<?php

namespace App\Http\Controllers;

use App\Exercise;
use App\ExerciseQuestion;
use App\Question;
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
        $question = DB::table('exercise_question')
            ->join('exercise', 'exercise_question.exercise_id', 'exercise.id')
            ->join('question', 'exercise_question.question_id', 'question.id')
            ->where('exercise_question.exercise_id', $request->exercise_id)
            ->where('exercise_question.isRemoved', '=', 0)
            ->select('exercise_question.id', 'question.title', 'question.topic', 'exercise_question.no', 'question.id as question_id')
            ->orderBy('exercise_question.no')
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
        $exercise = DB::table('exercise_question')
            ->join('exercise', 'exercise_question.exercise_id', 'exercise.id')
            ->join('question', 'exercise_question.question_id', 'question.id')
            ->where('exercise_question.exercise_id', $exercise_id)
            ->select('question.title', 'question.topic', 'question.title', 'question.description', 'exercise_question.exercise_id', 'exercise_question.no')
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
        $soal = DB::table('exercise_question')
            ->join('question', 'exercise_question.question_id', 'question.id')
            ->where('exercise_question.exercise_id', '=', $request->exercise_id)
            ->where('exercise_question.no', '=', $request->question_no)
            ->select('exercise_question.no', 'question.id', 'question.title', 'question.topic', 'question.dbname', 'question.description', 'question.required_table', 'question.test_code', 'question.guide', 'exercise_question.exercise_id')
            ->get();
        $jumlah_soal = ExerciseQuestion::where('exercise_id', '=', $request->exercise_id)->get()->count();
        return view('user.student.question.index', compact('soal', 'jumlah_soal'));
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