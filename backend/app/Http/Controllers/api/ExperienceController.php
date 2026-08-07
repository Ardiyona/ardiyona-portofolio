<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\ExperienceModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ExperienceController extends Controller
{
    public function getAll()
    {
        $experiences = Cache::remember('experience_api', 1800, function () {
            return ExperienceModel::all();
        });

        return response()->json([
            'status' => 'success',
            'data' => $experiences
        ]);
    }
}
