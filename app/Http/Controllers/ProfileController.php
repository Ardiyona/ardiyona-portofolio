<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function update(ProfileUpdateRequest $request)
    {
        $data = $request->validated();
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        $result = $this->userService->updateUser(Auth::id(), $data);

        if ($result['status']) {
            return back()->with('success', 'Profile berhasil diperbarui.');
        }

        return back()->withErrors(['name' => $result['message'] ?? 'Gagal memperbarui profile']);
    }
}
