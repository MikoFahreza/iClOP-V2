<?php

namespace App\Http\Controllers\Postgre;

use App\Models\Postgre\Question;
use App\Models\Postgre\ExerciseQuestion;
use App\Models\Postgre\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class QuestionController extends Controller
{
    public function getQuestionDataTable()
    {
        $soal = Question::all();
        return DataTables::of($soal)
            ->addColumn('actions', function ($row) {
                return '<div class="btn-group" role="group">
            <button id="detailBtn" type="button" class="btn btn-primary btn-sm" data-id="' . $row->id . '">
            <i class="fa fa-eye"></i>
            </button>
            <button id="questionDeleteBtn" type="button" class="btn btn-danger btn-sm" data-id="' . $row->id . '">
            <i class="fa fa-trash"></i>
            </button> 
            </div>';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }


    public function addQuestion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'topic' => 'required|string',
            'description' => 'required|string',
            'test_code' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $insert = Question::insert([
                    'title' => $request->title,
                    'topic' => $request->topic,
                    'description' => $request->description,
                    'test_code' => $request->test_code,
                ]);
            if ($insert) {
                return response()->json(['code' => 1, 'msg' => 'BERHASIL menambahkan soal baru.']);
            } else {
                return response()->json(['code' => 0, 'msg' => 'GAGAL menambahkan soal baru.']);
            }
        }
    }

    public function getQuestionDetail(Request $request)
    {
        $detailSoal = Question::find($request->question_id);
        return response()->json(['code' => 1, 'details' => $detailSoal]);
    }


    public function updateQuestion(Request $request)
    {
        $question_id = $request->qid;
        $task = Question::find($question_id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'topic' => 'required|string',
            'description' => 'required|string',
            'test_code' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $update = $task->update([
                        'title' => $request->title,
                        'topic' => $request->topic,
                        'description' => $request->description,
                        'test_code' => $request->test_code,
                    ]);
            if ($update) {
                return response()->json(['code' => 1, 'msg' => 'BERHASIL memperbarui soal.']);
            } else {
                return response()->json(['code' => 0, 'msg' => 'GAGAL memperbarui soal.']);
            }
        }
    }

    public function deleteQuestion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        }

        DB::beginTransaction();
        try {
            $question_id = $request->question_id;
            $question = Question::find($question_id);

            if (!$question) {
                return response()->json(['code' => 0, 'msg' => 'Question tidak ditemukan']);
            }

            // 1. Hapus semua submission yang terkait dengan question ini
            Submission::where('question_id', $question_id)->delete();

            // 2. Hapus data exercise_question yang terkait dengan question ini
            ExerciseQuestion::where('question_id', $question_id)->delete();

            // 3. Hapus question
            $question->delete();

            DB::commit();
            return response()->json(['code' => 1, 'msg' => 'Question berhasil dihapus']);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['code' => 0, 'msg' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
}