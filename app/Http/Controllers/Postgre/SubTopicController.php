<?php

namespace App\Http\Controllers\Postgre;

use App\Models\Postgre\SubTopic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class SubTopicController extends Controller
{
    public function getSubTopicDataTable()
    {
        $subTopics = SubTopic::with('topic')->get();

        return DataTables::of($subTopics)
            ->addColumn('topic_name', function ($row) {
                return $row->topic->name ?? '-';
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

    public function addSubTopic(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'topic_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            SubTopic::create([
                'name' => $request->name,
                'topic_id' => $request->topic_id,
            ]);
            return response()->json(['code' => 1, 'message' => 'Sub Topic added successfully']);
        }
    }

    public function deleteSubTopic(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $subTopic = SubTopic::find($request->id);
            if ($subTopic) {
                $subTopic->delete();
                return response()->json(['code' => 1, 'message' => 'Sub Topic deleted successfully']);
            } else {
                return response()->json(['code' => 0, 'message' => 'Sub Topic not found']);
            }
        }
    }
}