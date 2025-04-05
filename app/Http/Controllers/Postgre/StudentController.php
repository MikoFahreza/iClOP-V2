<?php

namespace App\Http\Controllers;

use App\Exercise;
use App\ExerciseQuestion;
use App\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables;

class StudentController extends Controller
{
    public function dashboard()
    {
        return view('user.student.dashboard');
    }

    public function exercise()
    {
        $exercise = Exercise::with('year')->get();
        return view('user.student.exercise.index', compact('exercise'));
    }

    public function exerciseQuestion(Request $request)
    {
        $exercise_id = $request->exercise_id;
        return view('user.student.exercise_question.index', compact('exercise_id'));
    }

    public function result()
    {
        $exercise = Exercise::with('year')->get();
        return view('user.student.result.index', compact('exercise'));
    }

    public function resultByExercise(Request $request)
    {
        $exercise_id = $request->exercise_id;
        $passed = DB::table('exercise_question')
            ->join('submissions', 'exercise_question.question_id', 'submissions.question_id')
            ->join('question', 'exercise_question.question_id', 'question.id')
            ->where('exercise_question.exercise_id', $request->exercise_id)
            ->where('submissions.student_id', Auth::user()->id)->get()->count();
            
        $question = DB::table('exercise_question')->where('exercise_id', 1)->get()->count();
        $result = floor(($passed / $question) * 100);
        return view('user.student.result.resultByExercise', compact('exercise_id', 'passed', 'question', 'result'));
    }

    public function getResultByExerciseDataTable(Request $request)
    {
        $nilai = DB::table('exercise_question')
            ->join('submissions', 'exercise_question.question_id', 'submissions.question_id')
            ->join('question', 'exercise_question.question_id', 'question.id')
            ->where('exercise_question.exercise_id', $request->exercise_id)
            ->where('submissions.student_id', Auth::user()->id)
            ->select('submissions.id', 'exercise_question.no', 'question.title', 'submissions.status', 'submissions.created_at', 'submissions.updated_at');

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