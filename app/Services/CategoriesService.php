<?php

namespace App\Services;

use App\Models\CategoriesModel;
use Illuminate\Support\Facades\DB;

/**
 * Class CategoriesService.
 */
class CategoriesService
{
    public function createCategory($data)
    {
        DB::beginTransaction();
        try {
            $category = CategoriesModel::create($data);

            DB::commit();

            return ['status' => true, 'category' => $category];
        } catch (\Throwable $th) {
            DB::rollBack();

            return ['status' => false, 'message' => 'Gagal membuat kategori ' . $th->getMessage()];
        }
    }

    public function updateCategory($id, $data)
    {
        DB::beginTransaction();
        try {
            $category = CategoriesModel::findOrFail($id);
            $category->update($data);

            DB::commit();

            return ['status' => true, 'category' => $category];
        } catch (\Throwable $th) {
            DB::rollBack();

            return ['status' => false, 'message' => 'Gagal mengupdate kategori ' . $th->getMessage()];
        }
    }

    public function deleteCategory($id)
    {
        DB::beginTransaction();
        try {
            $category = CategoriesModel::findOrFail($id);
            $category->delete();

            DB::commit();

            return ['status' => true, 'category' => $category];
        } catch (\Throwable $th) {
            DB::rollBack();

            return ['status' => false, 'message' => 'Gagal menghapus kategori ' . $th->getMessage()];
        }
    }
}
