<?php

namespace App\Http\Controllers\Postgre;

use App\Models\Postgre\Exercise;
use App\Models\Postgre\ExerciseQuestion;
use App\Models\Postgre\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

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
                    'duration' => $request->duration * 60,
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

    public function deleteExercise(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'exercise_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        }

        DB::beginTransaction();
        try {
            $exercise_id = $request->exercise_id;
            $exercise = Exercise::find($exercise_id);

            if (!$exercise) {
                return response()->json(['code' => 0, 'msg' => 'Exercise tidak ditemukan']);
            }

            // 1. Hapus semua submission yang terkait dengan exercise ini
            $exerciseQuestions = ExerciseQuestion::where('exercise_id', $exercise_id)->get();
            foreach ($exerciseQuestions as $eq) {
                Submission::where('question_id', $eq->question_id)->delete();
            }

            // 2. Hapus data exercise_question yang terkait dengan exercise ini
            ExerciseQuestion::where('exercise_id', $exercise_id)->delete();

            // 3. Hapus file panduan jika ada
            if ($exercise->guide) {
                $filePath = 'function_guidance/' . $exercise->guide;
                if (Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }
            }

            // 4. Hapus exercise
            $exercise->delete();

            DB::commit();
            return response()->json(['code' => 1, 'msg' => 'Exercise berhasil dihapus']);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['code' => 0, 'msg' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
}