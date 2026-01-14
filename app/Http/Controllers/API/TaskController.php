<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        $tasks = Task::with('project')->get();

        return response()->json($tasks, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
         $validated = $request->validate([
        'project_id' => 'required|',
        'title' => 'required|string|max:255',
        'info' => 'nullable|string',
        'status' => 'in:pending, in_progress, completed',
        'due_date' => 'nullable',
    ]);

    $tasks = Task::create($validated);

    return response()->json($tasks, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //

        $task = Task::with('project')->find($id);

        if(!$task) {
            return response()->json([
                'message' => 'task not founded'
            ] , 404);
        }

        return response()->json($task, 200);
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, string $id)
{
    $task = Task::find($id);

    if (!$task) {
        return response()->json([
            'message' => 'Task not found'
        ], 404);
    }

    $validated = $request->validate([
        'project_id' => 'required|exists:projects,id',
        'title'      => 'required|string|max:255',
        'info'       => 'nullable|string',
        'status'     => 'required|in:pending,in_progress,completed',
        'due_date'   => 'nullable|date',
    ]);

    $task->update($validated);

    return response()->json([
        'message' => 'Task updated successfully',
        'task'    => $task
    ], 200);
}
    /**
     * Remove the specified resource from storage.
     */
   public function destroy(string $id)
{
    $task = Task::with('project')->find($id);

    if (!$task) {
        return response()->json([
            'message' => 'Task not found'
        ], 404);
    }

    $task->delete();

    return response()->json([
        'message' => 'Task deleted successfully'
    ], 200);
}

}
