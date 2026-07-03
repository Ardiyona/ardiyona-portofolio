<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\UserModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        if ($request->wantsJson()) {
            $users = UserModel::all(['id', 'name', 'email']);
            return response()->json(['data' => $users]);
        }

        return view('admin.users.index');
    }

    public function store(UserStoreRequest $request): JsonResponse
    {
        UserModel::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['success' => true, 'message' => 'Pengguna berhasil ditambahkan.']);
    }

    public function show($id): JsonResponse
    {
        $user = UserModel::findOrFail($id);
        return response()->json($user);
    }

    public function update(UserUpdateRequest $request, $id): JsonResponse
    {
        $user = UserModel::findOrFail($id);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return response()->json(['success' => true, 'message' => 'Pengguna berhasil diperbarui.']);
    }

    public function destroy($id): JsonResponse
    {
        $user = UserModel::findOrFail($id);
        $user->delete();

        return response()->json(['success' => true, 'message' => 'Pengguna berhasil dihapus.']);
    }
}
