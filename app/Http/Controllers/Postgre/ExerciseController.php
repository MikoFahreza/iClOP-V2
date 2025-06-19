<?php

namespace App\Http\Controllers\Postgre;

use App\Models\Postgre\Exercise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ExerciseController extends Controller
{
    public function addExercise(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'required|string',
            'duration' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $path = 'function_guidance/';
            $file = $request->file('guidance');
            $file_name = $file->getClientOriginalName();

            $upload = $file->storeAs($path, $file_name, 'public');

            if ($upload) {
                Exercise::insert([
                    'name' => $request->name,
                    'description' => $request->description,
                    'guide' => $file_name,
                    'duration' => $request->duration * 60, // simpan dalam detik
                ]);
                return response()->json(['code' => 1, 'msg' => 'BERHASIL menambahkan latihan baru.']);
            } else {
                return response()->json(['code' => 0, 'msg' => 'GAGAL menambahkan latihan baru.']);
            }
        }
    }

    public function getExerciseDetail(Request $request)
    {
        $detail = Exercise::where('id', $request->eid)->get();
        return response()->json(['code' => 1, 'details' => $detail]);
    }

    public function updateExercise(Request $request)
    {
        $eid = $request->eid;
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'required|string',
            'duration' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $exercise = Exercise::find($eid);
            $path = 'function_guidance/';
            if ($request->hasFile('guidance_update')) {
                $file_path = $path . $exercise->guidance;
                if ($exercise->guidance != null && Storage::disk('public')->exists($file_path)) {
                    Storage::disk('public')->delete($file_path);
                }
                $file = $request->file('guidance_update');
                $file_name = $file->getClientOriginalName();
                $upload = $file->storeAs($path, $file_name, 'public');

                if ($upload) {
                    $exercise->update([
                        'name' => $request->name,
                        'description' => $request->description,
                        'guide' => $file_name,
                        'duration' => $request->duration * 60,
                    ]);
                    return response()->json(['code' => 1, 'msg' => 'BERHASIL memperbarui data latihan.']);
                }
            } else {
                $exercise->update([
                    'name' => $request->name,
                    'description' => $request->description,
                    'duration' => $request->duration * 60,
                ]);
                return response()->json(['code' => 1, 'msg' => 'BERHASIL memperbarui data latihan.']);
            }
        }
    }

    public function getExerciseAsOption(Request $request)
    {
        $data['exercise'] = Exercise::all();
        return response()->json($data);
    }

    public function getExerciseIDForDataTable(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'exercise_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            return response()->json(['code' => 1, 'msg' => $request->exercise_id]);
        }
    }
}