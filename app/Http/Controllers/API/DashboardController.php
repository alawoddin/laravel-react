<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function stats () {
        return response()->json([
            'projects_count' => Project::count(),
            'tasks_count' => Task::count(),
        ]);
    }
}
