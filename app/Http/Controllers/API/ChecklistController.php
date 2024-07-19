<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Helpers\JsonApiResponse;
use App\Models\Checklist;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ChecklistController extends Controller
{
    public function index()
    {
        $checklists = Checklist::get();

        return JsonApiResponse::success($checklists);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'to_do_id' => 'required',
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return JsonApiResponse::error($validator->errors(), Response::HTTP_BAD_REQUEST);
        }

        $checklist = new Checklist([
            'to_do_id' => $request->to_do_id,
            'name' => $request->name,
        ]);
        $checklist->save();

        return JsonApiResponse::success($checklist, Response::HTTP_CREATED);
    }

    public function destroy(string $id)
    {
        $checklist = Checklist::findOrFail($id);

        if (!$checklist) {
            return JsonApiResponse::error("checklist not found", Response::HTTP_NOT_FOUND);
        }

        $checklist->delete();

        return JsonApiResponse::success($checklist, "checklist Delete Successfully");
    }
}
