<?php

namespace App\Http\Controllers;

use App\Exercise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ExerciseResultController extends Controller
{
    public function exerciseResultByClass(Request $request)
    {
        $exercise = Exercise::all();
        $class_id = $request->class_id;
        return view('user.teacher.exerciseResult.exerciseResultByClass', compact('exercise', 'class_id'));
    }

    public function getExerciseIDForDataTable(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'exercise_id' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            return response()->json(['code' => 1, 'msg' => $request->exercise_id]);
        }
    }

    public function exerciseResultByExerciseDataTable(Request $request)
    {
        $class_id = $request->class_id;

        $student = DB::table('class_student')
            ->join('class', 'class_student.class_id', 'class.id')
            ->join('users', 'class_student.student_id', 'users.id')
            ->where('class_student.class_id', $class_id)
            ->select('users.id', 'users.name as username', 'class.name as classname')
            ->get();

        return DataTables::of($student)
            ->addColumn('passed', function ($row, Request $request) {
                $passed = DB::table('exercise_question')
                    ->join('submissions', 'exercise_question.question_id', 'submissions.question_id')
                    ->where('exercise_question.exercise_id', $request->exercise_id)
                    ->where('submissions.student_id', $row->id)
                    ->where('submissions.status', 'Passed')
                    ->select('submissions.id')
                    ->count();
                return $passed;
                //return floor(($passed / $jumlah_soal) * 100);
            })
            ->addColumn('jumlah_soal', function ($row, Request $request) {
                $jumlah_soal = DB::table('exercise_question')
                    ->where('exercise_question.exercise_id', $request->exercise_id)
                    ->select('exercise_question.id')
                    ->count();
                return $jumlah_soal;
            })
            ->addColumn('result', function ($row, Request $request) {
                $passed = DB::table('exercise_question')
                    ->join('submissions', 'exercise_question.question_id', 'submissions.question_id')
                    ->where('exercise_question.exercise_id', $request->exercise_id)
                    ->where('submissions.student_id', $row->id)
                    ->where('submissions.status', 'Passed')
                    ->select('submissions.id')
                    ->count();
                $jumlah_soal = DB::table('exercise_question')
                    ->where('exercise_question.exercise_id', $request->exercise_id)
                    ->select('exercise_question.id')
                    ->count();
                return floor(($passed / $jumlah_soal) * 100);
            })
            ->make(true);

    }
}