<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * INDEX
     * GET /api/tasks
     */
    public function index()
    {
        return response()->json(Task::all(), 200);
    }

    /**
     * STORE
     * POST /api/tasks
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|string',
            'album_number' => 'required|string'
        ]);

        $task = Task::create($validated);

        return response()->json($task, 201);
    }

    /**
     * SHOW
     * GET /api/tasks/{id}
     */
    public function show($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json([
                'message' => 'Task not found'
            ], 404);
        }

        return response()->json($task, 200);
    }

    /**
     * UPDATE
     * PUT /api/tasks/{id}
     */
    public function update(Request $request, $id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json([
                'message' => 'Task not found'
            ], 404);
        }

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|nullable|string',
            'status' => 'sometimes|string',
            'album_number' => 'sometimes|string'
        ]);

        $task->update($validated);

        return response()->json($task, 200);
    }

    /**
     * DESTROY
     * DELETE /api/tasks/{id}
     */
    public function destroy($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json([
                'message' => 'Task not found'
            ], 404);
        }

        $task->delete();

        return response()->json(null, 204);
    }
}