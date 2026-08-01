<?php

namespace App\Services;

use App\Models\ProjectModel;
use Illuminate\Support\Facades\DB;

/**
 * Class ProjectService.
 */
class ProjectService
{
    public function createProject($data)
    {
        try {
            DB::beginTransaction();

            $project = ProjectModel::create($data);
            $project->tech_stacks_project()->sync($data['tech_stack_id']);

            DB::commit();

            return ['status' => true, 'project' => $project];
        } catch (\Throwable $th) {
            DB::rollBack();

            return ['status' => false, 'message' => 'Gagal membuat project ' . $th->getMessage()];
        }
    }

    public function updateProject($data, $id)
    {
        try {
            DB::beginTransaction();

            $project = ProjectModel::findOrFail($id);
            $project->update($data);
            $project->tech_stacks_project()->sync($data['tech_stack_id']);

            DB::commit();

            return ['status' => true, 'project' => $project];
        } catch (\Throwable $th) {
            DB::rollBack();

            return ['status' => false, 'message' => 'Gagal mengubah project ' . $th->getMessage()];
        }
    }

    public function deleteProject($id)
    {
        try {
            DB::beginTransaction();

            $project = ProjectModel::findOrFail($id);
            $project->tech_stacks_project()->detach();
            $project->delete();

            DB::commit();

            return ['status' => true, 'project' => $project];
        } catch (\Throwable $th) {
            DB::rollback();

            return ['status' => false, 'message' => 'Gagal menghapus project ' . $th->getMessage()];
        }
    }
}
