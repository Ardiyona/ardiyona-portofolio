<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExperienceStoreRequest;
use App\Http\Requests\ExperienceUpdateRequest;
use App\Models\ExperienceModel;
use App\Services\ExperienceService;
use Yajra\DataTables\DataTables;

class ExperienceController extends Controller
{
    protected $experienceService;

    public function __construct(ExperienceService $experienceService)
    {
        $this->experienceService = $experienceService;
    }

    public function index()
    {
        return view('admin.experiences.index');
    }

    public function list()
    {
        return DataTables::of(ExperienceModel::select('id', 'position', 'company', 'location', 'work_arrangement', 'work_style', 'is_currently_working', 'work_start', 'work_end'))->make(true);
    }

    public function show($id)
    {
        $experience = ExperienceModel::findOrFail($id);
        return response()->json($experience);
    }

    public function store(ExperienceStoreRequest $request)
    {
        $result = $this->experienceService->createExperience($request->validated());

        if ($result['status']) {
            return response()->json(['success' => true, 'message' => 'Pengalaman berhasil dibuat']);
        }

        return response()->json(['success' => false, 'message' => $result['message'] ?? 'Gagal membuat pengalaman'], 500);
    }

    public function update(ExperienceUpdateRequest $request, $id)
    {
        $result = $this->experienceService->updateExperience($request->validated(), $id);

        if ($result['status']) {
            return response()->json(['success' => true, 'message' => 'Pengalaman berhasil diubah']);
        }

        return response()->json(['success' => false, 'message' => $result['message'] ?? 'Gagal mengubah pengalaman'], 500);
    }

    public function destroy($id)
    {
        $result = $this->experienceService->deleteExperience($id);

        if ($result['status']) {
            return response()->json(['success' => true, 'message' => 'Pengalaman berhasil dihapus']);
        }

        return response()->json(['success' => false, 'message' => $result['message'] ?? 'Gagal menghapus pengalaman'], 500);
    }
}
