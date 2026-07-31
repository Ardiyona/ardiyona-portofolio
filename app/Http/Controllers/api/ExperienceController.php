<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\ExperienceModel;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    public function getAll()
    {
        $experiences = ExperienceModel::with('category', 'tech_stacks_project')->get();

        return response()->json([
            'status' => 'success',
            'data' => $experiences
        ]);
    }
}
