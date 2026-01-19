<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        return response()->json(Project::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'info' => 'nullable|string',
            'due_date' => 'nullable',
        ]);

        $project = Project::create($validated);

        return response()->json($project, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //

        $project = Project::with('tasks')->find($id);
        if (!$project) {
            return response()->json([
                'message' => 'project not founded'
            ], 404);
        }
        return response()->json($project, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $project = Project::find($id);

        if (!$project) {
            return response()->json([
                'message' => 'project not found'
            ], 404);
        }

        // ✅ Fixed: Use -> instead of ::
        $project->update([
            'name' => $request->name,
            'info' => $request->info,
            'due_date' => $request->due_date,
        ]);

        // Optional: Refresh the model to get updated data
        $project->refresh();

        return response()->json($project, 200); // Use 200 for successful updates
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $project = Project::find($id);
        if (!$project) {
            return response()->json([
                'message' => 'project not founded'
            ], 404);
        }
        $project->delete();

        return response()->json([
            'message' => 'project is delete'
        ], 201);
    }
}
