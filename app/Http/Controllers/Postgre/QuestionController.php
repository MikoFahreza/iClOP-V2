<?php

namespace App\Http\Controllers\Postgre;

use App\Models\Postgre\Question;
use App\Models\Postgre\Topic;
use App\Models\Postgre\SubTopic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class QuestionController extends Controller
{
    public function getQuestionDataTable()
    {
        $soal = Question::with('subTopic.topic')->get();

        return DataTables::of($soal)
            ->addColumn('sub_topic_name', function ($row) {
                return $row->subTopic->name ?? '-';
            })
            ->addColumn('topic_name', function ($row) {
                return $row->subTopic->topic->name ?? '-';
            })
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
            'sub_topic_id' => 'required|string',
            'description' => 'required|string',
            'test_code' => 'required|string',
            'guidance' => 'required|mimes:pdf|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        } else {

            $path = 'function_guidance/';
            $file = $request->file('guidance');
            $file_name = $file->getClientOriginalName();

            $upload = $file->storeAs($path, $file_name, 'public');

            if ($upload) {
                Question::insert([
                    'title' => $request->title,
                    'sub_topic_id' => $request->sub_topic_id,
                    'description' => $request->description,
                    'test_code' => $request->test_code,
                    'guide' => $file_name,
                ]);
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
        $path = 'function_guidance/';

        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'sub_topic_id' => 'required|string',
            'description' => 'required|string',
            'test_code' => 'required|string',
            'guidance_update' => 'mimes:pdf|max:2048|unique:postgre_question,guide',
        ]);

        if ($validator->fails()) {
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            if ($request->hasFile('guidance_update')) {
                $file_path = $path . $task->guidance;
                if ($task->guidance != null && Storage::disk('public')->exists($file_path)) {
                    Storage::disk('public')->delete($file_path);
                }
                $file = $request->file('guidance_update');
                $file_name = $file->getClientOriginalName();
                $upload = $file->storeAs($path, $file_name, 'public');

                if ($upload) {
                    $task->update([
                        'title' => $request->title,
                        'sub_topic_id' => $request->sub_topic_id,
                        'description' => $request->description,
                        'test_code' => $request->test_code,
                        'guide' => $file_name,
                    ]);
                    return response()->json(['code' => 1, 'msg' => 'BERHASIL memperbarui data soal.']);
                }
            } else {
                $task->update([
                    'title' => $request->title,
                    'sub_topic_id' => $request->sub_topic_id,
                    'description' => $request->description,
                    'test_code' => $request->test_code,
                ]);
                return response()->json(['code' => 1, 'msg' => 'BERHASIL memperbarui data soal.']);
            }
        }
    }

    public function getTopics()
    {
        $topics = Topic::all(['id', 'name']);
        return response()->json($topics);
    }

    public function getSubTopicsByTopic($topic)
    {
        $list = SubTopic::where('topic_id', $topic)->get(['id','name']);
        return response()->json($list);
    }

}