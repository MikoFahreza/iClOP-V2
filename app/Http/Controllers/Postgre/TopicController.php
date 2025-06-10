<?php

namespace App\Http\Controllers\Postgre;

use App\Models\Postgre\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TopicController extends Controller
{
    public function addTopic(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'year_id' => 'required|numeric',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        } else {


            $topic = new Topic();
            $topic->name = $request->name;
            $topic->academic_year_id = $request->year_id;
            $topic->description = $request->description;
            $query = $topic->save();

            if (!$query) {
                return response()->json(['code' => 0, 'msg' => 'Terjadi kesalahan']);
            } else {
                return response()->json(['code' => 1, 'msg' => 'Latihan baru berhasil ditambahkan']);
            }
        }
    }

    public function getTopicDetail(Request $request)
    {
        $detail = Topic::with('year')->where('id', $request->eid)->get();
        return response()->json(['code' => 1, 'details' => $detail]);
    }

    public function updateTopic(Request $request)
    {
        $eid = $request->eid;
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'academic_year_id' => 'required',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $topic = Topic::find($eid);
            $topic->name = $request->name;
            $topic->academic_year_id = $request->academic_year_id;
            $topic->description = $request->description;
            $query = $topic->save();

            if (!$query) {
                return response()->json(['code' => 0, 'msg' => 'Terjadi kesalahan']);
            } else {
                return response()->json(['code' => 1, 'msg' => 'Tahun Ajaran berhasil diperbarui']);
            }
        }
    }

    public function getTopicAsOption(Request $request)
    {
        $data['topic'] = Topic::where('academic_year_id', $request->yid)->get();
        return response()->json($data);
    }

    public function getTopicIDForDataTable(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'topic_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            return response()->json(['code' => 1, 'msg' => $request->topic_id]);
        }
    }
}