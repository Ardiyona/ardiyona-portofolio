<?php

namespace App\Http\Controllers;

use App\Models\ViewLogs;
use Illuminate\Support\Facades\Request;

class ViewLogsController extends Controller
{
    public function index()
    {
        $viewLogCount = ViewLogs::count();

        return view('admin.dashboard', compact('viewLogCount'));
    }
}
