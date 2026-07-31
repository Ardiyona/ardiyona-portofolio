<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\ProjectModel;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function getAll()
    {
        $projects = ProjectModel::all();

        return response()->json([
            'status' => 'success',
            'data' => $projects
        ]);
    }
}
