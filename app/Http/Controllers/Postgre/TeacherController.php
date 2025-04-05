<?php

namespace App\Http\Controllers;

use App\AcademicYear;
use App\Classes;
use App\Exercise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Psy\Util\Json;

class TeacherController extends Controller
{
    public function dashboard()
    {
        return view('user.teacher.dashboard');
    }

    public function class()
    {
        $class = Classes::where('teacher_id', 1)->paginate(2);
        return view('user.teacher.class.index', compact('class'));
    }

    public function getClassStudent(Request $request)
    {
        $class_id = $request->class_id;
        
    }

    public function getClass()
    {
        $class = Classes::where('teacher_id', 1)->get();
        return response()->json(['code' => 1, 'details' => $class]);
    }

    public function question()
    {
        return view('user.teacher.question.index');
    }

    public function exercise()
    {
        $exercise = Exercise::with('year')->paginate(3);
        $year = AcademicYear::where('status', 'Aktif')->get();
        return view('user.teacher.exercise.index', compact('exercise', 'year'));
    }

    public function exerciseQuestion(Request $request)
    {
        $exercise = Exercise::with('year')->paginate(3);
        $year = AcademicYear::where('status', 'Aktif')->get();
        $exercise_id = $request->exercise_id;
        return view('user.teacher.exerciseQuestion.index',compact('exercise', 'year','exercise_id'));
    }

    public function exerciseResult(Request $request)
    {
        // $class = Classes::where('teacher_id', Auth::user()->id)->get();
        $class = DB::table('teacher')
            ->join('users', 'teacher.user_id', 'users.id')
            ->join('class', 'teacher.id', 'class.teacher_id')
            ->where('users.id', Auth::user()->id)
            ->select('class.id', 'class.name')
            ->get();
        return view('user.teacher.exerciseResult.index', compact('class'));
    }

}