<?php

namespace App\Http\Controllers;

use App\Http\Requests\TechStacksStoreRequest;
use App\Http\Requests\TechStacksUpdateRequest;
use App\Models\TechStackModel;
use App\Services\TechStackService;
use Yajra\DataTables\DataTables;

class TechStackController extends Controller
{
    protected $techStackService;

    public function __construct(TechStackService $techStackService)
    {
        $this->techStackService = $techStackService;
    }

    public function index()
    {
        return view('admin.tech-stacks.index');
    }

    public function list()
    {
        return DataTables::of(TechStackModel::select('id','name','code'))->make(true);
    }

    public function show($id)
    {
        $techStack = TechStackModel::findOrFail($id);

        return response()->json($techStack);
    }

    public function all()
    {
        $techStacks = TechStackModel::select('id', 'name')->get();

        return response()->json($techStacks);
    }

    public function store(TechStacksStoreRequest $request)
    {
        $result = $this->techStackService->createTechStack($request->validated());

        if ($result['status']) {
            return response()->json(['success' => true, 'message' => 'Tech Stack berhasil dibuat']);
        }
        return response()->json(['message' => $result['message'] ?? 'Gagal membuat tech stack'], 500);
    }

    public function update(TechStacksUpdateRequest $request, $id)
    {
        $result = $this->techStackService->updateTechStack($id, $request->validated());

        if ($result['status']) {
            return response()->json(['success' => true, 'message' => 'Tech Stack berhasil diubah']);
        }
        return response()->json(['message' => $result['message'] ?? 'Gagal mengubah tech stack'], 500);
    }

    public function destroy($id)
    {
        $techStack = TechStackModel::findOrFail($id);
        $techStack->delete();

        return response()->json(['success' => true, 'message' => 'Tech Stack berhasil dihapus.']);
    }
}
