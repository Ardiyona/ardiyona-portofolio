<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\UserModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
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
