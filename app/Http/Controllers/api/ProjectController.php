<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\ProjectModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProjectController extends Controller
{
    public function getAll()
    {
        $projects = ProjectModel::select('id', 'category_id', 'title', 'description')->with('category', 'tech_stacks_project')->get();

        Log::info($projects);

        return response()->json([
            'status' => 'success',
            'data' => $projects
        ]);
    }
}
