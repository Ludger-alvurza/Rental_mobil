<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestingController extends Controller
{
    public function changePassword()
    {
        return view('content.user.change-password');
    }

    public function updatePassword(Request $request)
{
    $request->validate([
        'old_password' => 'required',
        'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
        'password_confirmation' => 'required_with:password|same:password|min:6',
    ]);

    $user = Auth::user();
    
    // Cek password lama
    if (!password_verify($request->old_password, $user->password)) {
        return response()->json([
            'status' => 'error',
            'message' => 'Password lama salah'
        ], 422);
    }

    // Update password jika valid
    $user->password = password_hash($request->password, PASSWORD_DEFAULT);
    $user->save();

    return response()->json([
        'status' => 'success',
        'message' => 'Password berhasil diubah'
    ]);
}

 
}
