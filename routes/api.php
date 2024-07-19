<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ChecklistController;
use App\Http\Controllers\API\ChecklistItemController;
use App\Http\Controllers\API\ToDoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware('api')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::group(['middleware' => ['auth:api']], function () {
        Route::post('logout', [AuthController::class, 'logout']);

        Route::get('todo', [ToDoController::class, 'index']);
        Route::post('todo', [ToDoController::class, 'store']);
        Route::put('todo/{id}', [ToDoController::class, 'update']);
        Route::delete('todo/{id}', [ToDoController::class, 'destroy']);

        Route::get('checklist', [ChecklistController::class, 'index']);
        Route::post('checklist', [ChecklistController::class, 'store']);
        Route::delete('checklist/{id}', [ChecklistController::class, 'destroy']);

        Route::get('checklist/{checklistId}/item', [ChecklistItemController::class, 'index']);
        Route::get('checklist/{checklistId}/item/{checklistItemId}', [ChecklistItemController::class, 'index']);
        Route::post('checklist/{checklistId}/item', [ChecklistItemController::class, 'store']);
        Route::put('checklist/{checklistId}/item/{checklistItemId}', [ChecklistItemController::class, 'updateStatus']);
        Route::put('checklist/{checklistId}/item/rename/{checklistItemId}', [ChecklistItemController::class, 'update']);
        Route::delete('checklist/{checklistId}/item/{checklistItemId}', [ChecklistItemController::class, 'destroy']);
    });
});
