<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\UserModel;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(): View
    {
        return view('admin.users.index');
    }

    public function list(): JsonResponse
    {
        return DataTables::of(UserModel::select('id','name','email'))->make(true);
    }

    public function store(UserStoreRequest $request): JsonResponse
    {
        $result = $this->userService->createUser($request->validated());

        if ($result['status']) {
            return response()->json(['success' => true, 'message' => 'Pengguna berhasil ditambahkan.']);
        }

        return response()->json(['success' => false, 'message' => $result['message'] ?? 'Gagal membuat pengguna'], 500);
    }

    public function show($id): JsonResponse
    {
        $user = UserModel::findOrFail($id);
        return response()->json($user);
    }

    public function update(UserUpdateRequest $request, $id): JsonResponse
    {
        $data = $request->validated();
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        $result = $this->userService->updateUser($id, $data);

        if ($result['status']) {
            return response()->json(['success' => true, 'message' => 'Pengguna berhasil diperbarui.']);
        }

        return response()->json(['success' => false, 'message' => $result['message'] ?? 'Gagal mengubah pengguna'], 500);
    }

    public function destroy($id): JsonResponse
    {
        $result = $this->userService->deleteUser($id);

        if ($result['status']) {
            return response()->json(['success' => true, 'message' => 'Pengguna berhasil dihapus.']);
        }

        return response()->json(['success' => false, 'message' => $result['message'] || 'Gagal menghapus pengguna.'], 500);
    }
}
