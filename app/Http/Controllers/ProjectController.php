<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectStoreRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Models\ProjectModel;
use App\Services\ProjectService;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProjectController extends Controller
{
    protected $projectService;

    public function __construct(ProjectService $projectService) {
        $this->projectService = $projectService;
    }

    public function index()
    {
        return view('admin.projects.index');
    }

    public function list()
    {
        return DataTables::of(ProjectModel::with('category', 'tech_stacks_project')->select('id', 'category_id', 'title', 'description'))->make(true);
    }

    public function show($id)
    {
        $project = ProjectModel::with('tech_stacks_project')->findOrFail($id);
        return response()->json($project);
    }

    public function store(ProjectStoreRequest $request)
    {
        $result = $this->projectService->createProject($request->validated());

        if ($result['status']) {
            return response()->json(['success' => true, 'message' => 'Project berhasil dibuat']);
        }

        return response()->json(['success' => false, 'message' => $result['message'] || 'Project gagal dibuat'], 500);
    }

    public function update(ProjectUpdateRequest $request, $id)
    {
        $result = $this->projectService->updateProject($request->validated(), $id);

        if ($result['status']) {
            return response()->json(['success' => true, 'message' => 'Project berhasil diubah']);
        }

        return response()->json(['success' => false, 'message' => $result['message'] || 'Project gagal diubah'], 500);
    }

    public function destroy($id)
    {
        $result = $this->projectService->deleteProject($id);

        if ($result['status']) {
            return response()->json(['success' => true, 'message' => 'Project berhasil dihapus']);
        }

        return response()->json(['success' => false, 'message' => $result['message'] || 'Project gagal dihapus'], 500);
    }
}
