<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\ProjectModel;
use Illuminate\Support\Facades\Cache;

class ProjectController extends Controller
{
    public function getAll()
    {
        $projects = Cache::remember('project_api', 1800, function () {
            return ProjectModel::select('id', 'category_id', 'title', 'description')->with('category', 'tech_stacks_project')->get();
        });

        return response()->json([
            'status' => 'success',
            'data' => $projects
        ]);
    }
}
