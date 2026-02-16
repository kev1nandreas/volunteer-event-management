<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        try {
            if (!Auth::attempt($credentials)) {
                return $this->error(
                    error: "Kredensial tidak valid",
                    success: false,
                    code: 401,
                    message: "Kredensial yang diberikan tidak sesuai dengan catatan kami"
                );
            }

            /** @var User $user */
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;

            return $this->success(
                data: ['token' => $token],
                success: true,
                code: 200,
                message: 'Login berhasil'
            );
        } catch (\Exception $e) {
            return $this->error(
                message: 'Login gagal',
                error: ['error' => $e->getMessage()],
                code: 500
            );
        }
    }

    public function logout()
    {
        try {
            Auth::user()->tokens()->delete();

            return $this->success(
                success: true,
                code: 200,
                message: 'Logout berhasil'
            );
        } catch (\Exception $e) {
            return $this->error(
                message: 'Logout gagal',
                error: ['error' => $e->getMessage()],
                code: 500
            );
        }
    }

    public function register(RegisterRequest $request)
    {
        try {
            $data = $request->validated();
            $user = User::create($data);
            $token = $user->createToken('auth_token')->plainTextToken;

            return $this->created(
                data: ['token' => $token],
                success: true,
                code: 201,
                message: 'Registrasi berhasil'
            );
        } catch (\Exception $e) {
            return $this->error(
                message: 'Registrasi gagal',
                error: ['error' => $e->getMessage()],
                code: 500
            );
        }
    }

    public function me()
    {
        try {
            $user = Auth::user();

            return $this->success(
                data: ['user' => $user],
                success: true,
                code: 200,
                message: 'Profil pengguna berhasil diambil'
            );
        } catch (\Exception $e) {
            return $this->error(
                message: 'Gagal mengambil profil pengguna',
                error: ['error' => $e->getMessage()],
                code: 500
            );
        }
}
}