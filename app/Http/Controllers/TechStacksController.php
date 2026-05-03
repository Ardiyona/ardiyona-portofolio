<?php

namespace App\Http\Controllers;

use App\Http\Requests\TechStacksStoreRequest;
use App\Http\Requests\TechStacksUpdateRequest;
use App\Models\TechStacksModel;
use App\Services\TechStacksService;
use Illuminate\Http\Request;

class TechStacksController extends Controller
{
    protected $techStacksService;

    public function __construct(TechStacksService $techStacksService)
    {
        $this->techStacksService = $techStacksService;
    }

    public function index()
    {
        $techStacks = TechStacksModel::all();

        return view('admin.tech-stacks.index', compact('techStacks'));
    }

    public function show($id)
    {
        $techStack = TechStacksModel::findOrFail($id);

        return response()->json($techStack);
    }

    public function store(TechStacksStoreRequest $request)
    {
        $result = $this->techStacksService->createTechStack($request->validated());

        if ($result['status']) {
            session()->flash('success', 'Tech Stack berhasil dibuat');
            return response()->json(['success' => true, 'message' => 'Tech Stack berhasil dibuat']);
        }
        return response()->json(['message' => $result['message'] ?? 'Gagal membuat tech stack'], 500);
    }

    public function update(TechStacksUpdateRequest $request, $id)
    {
        $result = $this->techStacksService->updateTechStack($id, $request->validated());

        if ($result['status']) {
            session()->flash('success', 'Tech Stack berhasil diubah');
            return response()->json(['success' => true, 'message' => 'Tech Stack berhasil diubah']);
        }
        return response()->json(['message' => $result['message'] ?? 'Gagal mengubah tech stack'], 500);
    }

    public function destroy($id)
    {
        $result = $this->techStacksService->deleteTechStack($id);

        if ($result['status']) {
            session()->flash('success', 'Tech Stack berhasil dihapus');
            return redirect()->route('admin.tech-stacks.index')->with('success', 'Tech Stack berhasil dihapus.');
        }
        return redirect()->route('admin.tech-stacks.index')->with('error', 'Tech Stack gagal dihapus.');
    }
}
