<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Helpers\JsonApiResponse;
use App\Models\ChecklistItem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ChecklistItemController extends Controller
{
    public function index(string $checklistId)
    {
        $checklistItems = ChecklistItem::where('checklist_id', $checklistId)->get();

        return JsonApiResponse::success($checklistItems);
    }

    public function store(Request $request, string $checklistId)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return JsonApiResponse::error($validator->errors(), Response::HTTP_BAD_REQUEST);
        }

        $checklistItem = new ChecklistItem([
            'checklist_id' => $checklistId,
            'name' => $request->itemName,
            'status' => false,
        ]);
        $checklistItem->save();

        return JsonApiResponse::success($checklistItem);
    }

    public function getChecklistItemByID(string $checklistId, string $checklistItemId)
    {
        $checklistItem = ChecklistItem::where('checklist_id', $checklistId)->findOrFail($checklistItemId);

        if (!$checklistItem) {
            return JsonApiResponse::error("checklist item not found", Response::HTTP_NOT_FOUND);
        }

        return JsonApiResponse::success($checklistItem);
    }

    public function update(Request $request, string $checklistId, string $checklistItemId)
    {
        $checklistItem = ChecklistItem::where('checklist_id', $checklistId)->findOrFail($checklistItemId);

        if (!$checklistItem) {
            return JsonApiResponse::error("checklist item not found", Response::HTTP_NOT_FOUND);
        }

        $checklistItem->update([
            'name' => $request->itemName,
        ]);

        return JsonApiResponse::success($checklistItem);
    }

    public function destroy(string $checklistId, string $checklistItemId)
    {
        $checklistItem = ChecklistItem::where('checklist_id', $checklistId)->findOrFail($checklistItemId);

        if (!$checklistItem) {
            return JsonApiResponse::error("checklist item not found", Response::HTTP_NOT_FOUND);
        }

        $checklistItem->delete();

        return JsonApiResponse::success($checklistItem, "checklist item Delete Successfully");
    }

    public function updateStatus(string $checklistId, string $checklistItemId)
    {
        $checklistItem = ChecklistItem::where('checklist_id', $checklistId)->findOrFail($checklistItemId);

        if (!$checklistItem) {
            return JsonApiResponse::error("checklist item not found", Response::HTTP_NOT_FOUND);
        }

        $checklistItem->update([
            'status' => !$checklistItem->status,
        ]);

        return JsonApiResponse::success($checklistItem);
    }
}
