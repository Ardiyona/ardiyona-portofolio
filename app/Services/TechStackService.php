<?php

namespace App\Services;

use App\Models\TechStacksModel;
use Illuminate\Support\Facades\DB;

/**
 * Class TechStacksService.
 */
class TechStackService
{
    public function createTechStack($data)
    {
        try {
            DB::beginTransaction();

            $techStack = TechStacksModel::create($data);

            DB::commit();

            return ['status' => true, 'techStack' => $techStack];
        } catch (\Throwable $th) {
            DB::rollBack();

            return ['status' => false, 'message' => 'Gagal membuat tech stack ' . $th->getMessage()];
        }
    }

    public function updateTechStack($id, $data)
    {
        try {
            DB::beginTransaction();

            $techStack = TechStacksModel::findOrFail($id);
            $techStack->update($data);

            DB::commit();

            return ['status' => true, 'techStack' => $techStack];
        } catch (\Throwable $th) {
            DB::rollBack();

            return ['status' => false, 'message' => 'Gagal mengubah tech stack ' . $th->getMessage()];
        }
    }

    public function deleteTechStack($id)
    {
        try {
            DB::beginTransaction();

            $techStack = TechStacksModel::findOrFail($id);
            $techStack->delete();

            DB::commit();

            return ['status' => true, 'techStack' => $techStack];
        } catch (\Throwable $th) {
            DB::rollBack();

            return ['status' => false, 'message' => 'Gagal menghapus tech stack ' . $th->getMessage()];
        }
    }
}
