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
}
