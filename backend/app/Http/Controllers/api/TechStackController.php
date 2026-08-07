<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\TechStackModel;
use Illuminate\Support\Facades\Cache;

class TechStackController extends Controller
{
    public function getAll()
    {
        $techStacks = Cache::remember('techStack_api', 1800, function () {
            return TechStackModel::select('name')->get();
        });

        return response()->json([
            'status' => 'success',
            'data' => $techStacks
        ]);
    }
}
