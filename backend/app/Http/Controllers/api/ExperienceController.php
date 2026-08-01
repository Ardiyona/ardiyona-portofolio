<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\ExperienceModel;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    public function getAll()
    {
        $experiences = ExperienceModel::all();

        return response()->json([
            'status' => 'success',
            'data' => $experiences
        ]);
    }
}
