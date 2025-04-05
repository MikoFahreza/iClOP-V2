<?php

namespace App\Http\Controllers;

use App\Classes;
use App\ClassesStudent;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ClassesStudentController extends Controller
{
    public function getClassAsOption(Request $request)
    {
        $data['class'] = Classes::where('academic_year_id', $request->yid)->get();
        return response()->json($data);
    }

    public function getStudentDataTable()
    {
        // $student = DB::table('class_student')
        //     ->join('class', 'class_student.class_id', 'class.id')
        //     ->join('users', 'class_student.student_id', 'users.id')
        //     ->where('users.role', 'student')
        //     ->select('class_student.id', 'users.id as student_id', 'users.name', 'class.name as class_name')
        //     ->get();

        $student = User::where('role', 'student')->get();

        return DataTables::of($student)
            ->addColumn('actions', function ($row) {
                return '<div class="btn-group" role="group">
                <button id="assignStudentToClassBtn" type="button" class="btn btn-info btn-block" data-id="' . $row['id'] . '">
                <i class="fa fa-arrow-left"></i>
                </button> 
                </div>';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function getClassIDForDataTable(Request $request)
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

    public function getClassStudentDataTable(Request $request)
    {
        $student = DB::table('class_student')
            ->join('class', 'class_student.class_id', 'class.id')
            // ->join('student', 'class_student.student_id', 'student.id')
            ->join('users', 'class_student.student_id', 'users.id')
            ->where('class_student.class_id', $request->class_id)
            ->select('class_student.id', 'users.id as student_id', 'users.name', 'class.name as class_name')
            ->get();

        return DataTables::of($student)
            ->addColumn('actions', function ($row) {
                return '<div class="btn-group" role="group">
                <button id="removeStudentFromClassBtn" type="button" class="btn btn-danger btn-block" data-id="' . $row->student_id . '">
                <i class="fa fa-arrow-right"></i>
                </button> 
                </div>';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function assignStudentToClass(Request $request)
    {

        $student = ClassesStudent::updateOrCreate(
            ['student_id' => $request->student_id],
            ['class_id' => $request->class_id]
        );

        if (!$student) {
            return response()->json(['code' => 0, 'msg' => 'Terjadi kesalahan']);
        } else {
            return response()->json(['code' => 1, 'msg' => 'Mahasiswa berhasil ditambahkan']);
        }
    }

    public function removeStudentFromClass(Request $request)
    {

        $student = ClassesStudent::updateOrCreate(
            ['student_id' => $request->student_id],
            ['class_id' => null]
        );

        if (!$student) {
            return response()->json(['code' => 0, 'msg' => 'Terjadi kesalahan']);
        } else {
            return response()->json(['code' => 1, 'msg' => 'Mahasiswa berhasil dikeluarkan']);
        }
    }
}