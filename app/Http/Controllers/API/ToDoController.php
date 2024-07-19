<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Helpers\JsonApiResponse;
use App\Models\ToDo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ToDoController extends Controller
{
    public function index()
    {
        $todos = ToDo::paginate(10);

        return JsonApiResponse::success($todos);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ]);

        if ($validator->fails()) {
            return JsonApiResponse::error($validator->errors(), Response::HTTP_BAD_REQUEST);
        }

        $todo = new ToDo([
            'title' => $request->title,
        ]);
        $todo->save();

        return JsonApiResponse::success($todo, Response::HTTP_CREATED);
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ]);

        if ($validator->fails()) {
            return JsonApiResponse::error($validator->errors(), Response::HTTP_BAD_REQUEST);
        }

        $todo = ToDo::findOrFail($id);

        if (!$todo) {
            return JsonApiResponse::error("todo not found", Response::HTTP_NOT_FOUND);
        }

        $todo->title = $request->title;
        $todo->save();

        return JsonApiResponse::success($todo, "ToDo Update Successfully");
    }

    public function destroy(string $id)
    {
        $todo = ToDo::findOrFail($id);

        if (!$todo) {
            return JsonApiResponse::error("todo not found", Response::HTTP_NOT_FOUND);
        }

        $todo->delete();

        return JsonApiResponse::success($todo, "todo Delete Successfully");
    }
}
