<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'success'
            ], 200);
        } else {
            $trashed_user = User::withTrashed()->where('email', $request->email)->first();
            if ($trashed_user->trashed()) {
                return response()->json([
                    'message' => 'すでに削除されているユーザです'], 410);
            } else {
                return response()->json([
                'message' => '認証できません'
                ], 401);
            }
        }
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'message' => 'Logged out'
        ], 200);
    }
}
