<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\ViewLogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ViewLogsController extends Controller
{
    public function viewLog(Request $request)
    {
        $hasVisited = $request->cookie('has_visited');
        Log::info($request->cookie('has_visited'));

        if (!$hasVisited) {
            ViewLogs::create([
                'ip_address' => $request->ip(),
            ]);

            return response()
                ->json(['status' => 'success', 'logged' => true])
                ->cookie('has_visited', true, 60 * 24); // menit, jadi 60*24 = 1 hari
        }

        return response()->json(['status' => 'success', 'logged' => false]);
    }
}
