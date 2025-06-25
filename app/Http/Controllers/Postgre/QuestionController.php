<?php

namespace App\Http\Controllers\Postgre;

use App\Models\Postgre\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class QuestionController extends Controller
{
    public function getQuestionDataTable()
    {
        $soal = Question::all();
        return DataTables::of($soal)
            ->addColumn('actions', function ($row) {
                return '<div class="btn-group" role="group">
            <button id="detailBtn" type="button" class="btn btn-primary btn-block" data-id="' . $row->id . '">
            <i class="fa fa-eye"></i>
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
}