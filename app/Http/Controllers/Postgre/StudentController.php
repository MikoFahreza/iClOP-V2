<?php

namespace App\Http\Controllers\Postgre;

use App\Models\Postgre\Exercise;
use App\Models\Postgre\ExerciseQuestion;
use App\Models\Postgre\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables;

class StudentController extends Controller
{
    public function dashboard()
    {
        return view('postgre.user.student.dashboard');
    }

    public function exercise()
    {
        $exercise = Exercise::with('year')->get();
        return view('postgre.user.student.exercise.index', compact('exercise'));
    }

    public function exerciseQuestion(Request $request)
    {
        $exercise_id = $request->exercise_id;
        return view('postgre.user.student.exercise_question.index', compact('exercise_id'));
    }

    public function result()
    {
        $exercise = Exercise::with('year')->get();
        return view('postgre.user.student.result.index', compact('exercise'));
    }

    public function resultByExercise(Request $request)
    {
        $exercise_id = $request->exercise_id;
        $passed = DB::table('postgre_exercise_question')
            ->join('postgre_submissions', 'postgre_exercise_question.question_id', 'postgre_submissions.question_id')
            ->join('postgre_question', 'postgre_exercise_question.question_id', 'postgre_question.id')
            ->where('postgre_exercise_question.exercise_id', $request->exercise_id)
            ->where('postgre_submissions.student_id', Auth::user()->id)->get()->count();
            
        $question = DB::table('postgre_exercise_question')->where('exercise_id', 1)->get()->count();
        $result = floor(($passed / $question) * 100);
        return view('postgre.user.student.result.resultByExercise', compact('exercise_id', 'passed', 'question', 'result'));
    }

    public function getResultByExerciseDataTable(Request $request)
    {
        $nilai = DB::table('postgre_exercise_question')
            ->join('postgre_submissions', 'postgre_exercise_question.question_id', 'postgre_submissions.question_id')
            ->join('postgre_question', 'postgre_exercise_question.question_id', 'postgre_question.id')
            ->where('postgre_exercise_question.exercise_id', $request->exercise_id)
            ->where('postgre_submissions.student_id', Auth::user()->id)
            ->select('postgre_submissions.id', 'postgre_exercise_question.no', 'postgre_question.title', 'postgre_submissions.status', 'postgre_submissions.created_at', 'postgre_submissions.updated_at');

        return DataTables::of($nilai)
            ->addColumn('actions', function ($row) {
                return '<div class="btn-group" role="group">            
                <button id="jawaban" type="button" class="btn btn-primary btn-block" data-id=' . $row->id . '></i>Jawaban</button>
                </div>';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function getSubmissionResultDetail(Request $request)
    {
        $nilai = Submission::with('soal')->where('id', $request->submission_id)->get();
        return response()
            ->json(['details' => $nilai]);

    }
}