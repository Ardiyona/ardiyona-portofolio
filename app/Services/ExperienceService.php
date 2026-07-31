<?php

namespace App\Services;

use App\Models\ExperienceModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Class ExperienceService.
 */
class ExperienceService
{
    public function createExperience($data)
    {
        try {
            DB::beginTransaction();

            $experience = ExperienceModel::create($this->normalizeDates($data));

            DB::commit();

            return ['status' => true, 'experience' => $experience];
        } catch (\Throwable $th) {
            DB::rollBack();

            return ['status' => false, 'message' => 'Gagal membuat pengalaman ' . $th->getMessage()];
        }
    }

    public function updateExperience($data, $id)
    {
        try {
            DB::beginTransaction();

            $experience = ExperienceModel::findOrFail($id);
            $experience->update($this->normalizeDates($data));

            DB::commit();

            return ['status' => true, 'experience' => $experience];
        } catch (\Throwable $th) {
            DB::rollBack();

            return ['status' => false, 'message' => 'Gagal mengubah pengalaman ' . $th->getMessage()];
        }
    }

    public function deleteExperience($id)
    {
        try {
            DB::beginTransaction();

            $experience = ExperienceModel::findOrFail($id);
            $experience->delete();

            DB::commit();

            return ['status' => true, 'experience' => $experience];
        } catch (\Throwable $th) {
            DB::rollBack();

            return ['status' => false, 'message' => 'Gagal menghapus pengalaman ' . $th->getMessage()];
        }
    }

    /**
     * Convert m/Y input to a Y-m-d date for the date columns.
     * When still working, work_end is forced to null.
     */
    private function normalizeDates($data)
    {
        $data['work_start'] = Carbon::createFromFormat('m/Y', $data['work_start'])->startOfMonth()->format('Y-m-d');

        // Kenapa pakai ! empty($data['is_currently_working']) karena jika $data['is_currently_working'] dan berisi "false" maka php anggap true karena string bukan boolean
        $data['work_end'] = ! empty($data['is_currently_working']) || empty($data['work_end'])
            ? null
            : Carbon::createFromFormat('m/Y', $data['work_end'])->startOfMonth()->format('Y-m-d');

        return $data;
    }
}
