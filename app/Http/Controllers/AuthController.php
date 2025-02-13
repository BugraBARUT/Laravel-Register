<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6|confirmed',
            ]);

            User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Kayıt başarıyla tamamlandı!'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Bir hata oluştu. Lütfen tekrar deneyin.'
            ], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'success' => true,
                    'message' => 'E-posta veya şifre hatalı!'
                ], 401);
            }

            $token = $user->createToken('token-name')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Giriş başarılı!',
                'token' => $token,
                'redirect' => route('dashboard') // Yönlendirilecek sayfa
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Bir hata oluştu. Lütfen tekrar deneyin.'
            ], 500);
        }
    }
}
