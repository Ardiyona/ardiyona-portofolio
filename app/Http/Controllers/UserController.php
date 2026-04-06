<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = UserModel::all();
        return view('admin.users.index', compact('users'));
    }

    public function store(UserStoreRequest $request)
    {
        UserModel::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            session()->flash('success', 'Pengguna berhasil ditambahkan.');
            return response()->json(['success' => true, 'message' => 'Pengguna berhasil ditambahkan.']);
        }
    }

    public function update(UserUpdateRequest $request, $id)
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

        if ($request->ajax() || $request->wantsJson()) {
            session()->flash('success', 'Pengguna berhasil diperbarui.');
            return response()->json(['success' => true, 'message' => 'Pengguna berhasil diperbarui.']);
        }
    }

    public function destroy($id)
    {
        $user = UserModel::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
