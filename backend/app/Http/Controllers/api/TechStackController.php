<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\TechStackModel;
use Illuminate\Http\Request;

class TechStackController extends Controller
{
    public function getAll()
    {
        $techStacks = TechStackModel::select('name')->get();

        return response()->json([
            'status' => 'success',
            'data' => $techStacks
        ]);
    }
}
