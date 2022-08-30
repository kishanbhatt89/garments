<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChangePasswordController extends Controller
{
    public function changepasswordform() {
        return view('auth.changepassword');
    }

    public function changepassword(Request $request) {

        $request->validate([
            'password' => 'required|string|min:6',            
        ]);

        $user = auth()->user();        

        $user->password = bcrypt($request->password);
        $user->last_password_change_at = now();        

        if ($user->save()) {
            return redirect()->back()->with('success', 'Password changed successfully!');
        }

        return redirect()->back()->with('error', 'Error in changing password!');

    }
}
