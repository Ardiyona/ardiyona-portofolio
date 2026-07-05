<?php

namespace App\Services;

use App\Models\UserModel;
use Illuminate\Support\Facades\DB;

/**
 * Class UsersService.
 */
class UserService
{
    public function createUser($data)
    {
        try {
            DB::BeginTransaction();

            $user = UserModel::create($data);

            DB::commit();

            return ['status' => true, 'user' => $user];
        } catch (\Throwable $th) {
            DB::rollBack();

            return ['status' => false, 'message' => 'Gagal membuat pengguna ' . $th->getMessage()];
        }
    }

    public function updateUser($id, $data)
    {
        try {
            DB::beginTransaction();

            $user = UserModel::findOrFail($id);
            $user->update($data);

            DB::commit();

            return ['status' => true, 'user' => $user ];
        } catch (\Throwable $th) {
            DB::rollBack();

            return ['status' => false, 'message' => 'Gagal mengubah pengguna ' . $th->getMessage()];
        }
    }

    public function deleteUser($id)
    {
        try {
            DB::beginTransaction();

            $user = UserModel::findOrFail($id);
            $user->delete();

            DB::commit();

            return ['status' => true, 'user' => $user];
        } catch (\Throwable $th) {
            DB::rollback();

            return ['status' => false, 'message' => ' Gagal menghapus pengguna ' . $th->getMessage()];
        }
    }
}
