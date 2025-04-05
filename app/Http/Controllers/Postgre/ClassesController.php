<?php

namespace App\Http\Controllers;

use App\Classes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClassesController extends Controller
{
    public function addClass(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'academic_year_id' => 'required|numeric',
            'teacher_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $class = new Classes();
            $class->name = $request->name;
            $class->academic_year_id = $request->academic_year_id;
            $class->teacher_id = $request->teacher_id;
            $query = $class->save();

            if (!$query) {
                return response()->json(['code' => 0, 'msg' => 'Terjadi kesalahan']);
            } else {
                return response()->json(['code' => 1, 'msg' => 'Kelas baru berhasil ditambahkan']);
            }
        }
    }

    public function getClassDetail(Request $request)
    {
        $classDetail = Classes::with('teacher', 'year')->where('id', $request->class_id)->get();
        return response()->json(['code' => 1, 'details' => $classDetail]);
    }

    public function updateClass(Request $request)
    {
        $class_id = $request->cid;
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'academic_year_id' => 'required|numeric',
            'teacher_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $class = Classes::find($class_id);
            $class->name = $request->name;
            $class->academic_year_id = $request->academic_year_id;
            $class->teacher_id = $request->teacher_id;
            $query = $class->save();

            if (!$query) {
                return response()->json(['code' => 0, 'msg' => 'Terjadi kesalahan']);
            } else {
                return response()->json(['code' => 1, 'msg' => 'Kelas berhasil diperbarui']);
            }
        }
    }
}