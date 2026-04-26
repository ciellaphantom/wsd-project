<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Support\ApiError;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TaskController extends Controller
{
    /**
     * INDEX
     * GET /api/78709/v1/tasks
     * Expected status: 200 OK
     */
    public function index(): JsonResponse
    {
        $tasks = Cache::store('redis')->remember('tasks.index', 60, function () {
            return Task::all();
        });

        return response()->json($tasks, 200);
    }

    /**
     * STORE
     * POST /api/78709/v1/tasks
     * Expected status: 201 Created
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|string',
            'album_number' => 'required|string',
        ]);

        $task = Task::create($validated);

        // Invalidate cache after creating a new task
        Cache::store('redis')->forget('tasks.index');

        return response()->json($task, 201);
    }

    /**
     * SHOW
     * GET /api/78709/v1/tasks/{id}
     * Expected status: 200 OK or 404 Not Found
     */
    public function show(Request $request, $id): JsonResponse
    {
        try {
            $task = Task::findOrFail($id);

            return response()->json($task, 200);
        } catch (ModelNotFoundException $e) {
            return ApiError::make($request, 404, 'Task not found');
        }
    }

    /**
     * UPDATE
     * PUT /api/78709/v1/tasks/{id}
     * Expected status: 200 OK or 404 Not Found
     */
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $task = Task::findOrFail($id);

            $validated = $request->validate([
                'title' => 'sometimes|string|max:255',
                'description' => 'sometimes|nullable|string',
                'status' => 'sometimes|string',
                'album_number' => 'sometimes|string',
            ]);

            $task->update($validated);

            // Invalidate cache after updating a task
            Cache::store('redis')->forget('tasks.index');

            return response()->json($task, 200);
        } catch (ModelNotFoundException $e) {
            return ApiError::make($request, 404, 'Task not found');
        }
    }

    /**
     * DESTROY
     * DELETE /api/78709/v1/tasks/{id}
     * Expected status: 204 No Content or 404 Not Found
     */
    public function destroy(Request $request, $id): JsonResponse
    {
        try {
            $task = Task::findOrFail($id);

            $task->delete();

            // Invalidate cache after deleting a task
            Cache::store('redis')->forget('tasks.index');

            return response()->json(null, 204);
        } catch (ModelNotFoundException $e) {
            return ApiError::make($request, 404, 'Task not found');
        }
    }
}