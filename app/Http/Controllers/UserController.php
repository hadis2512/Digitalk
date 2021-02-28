<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function register_account(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:100|unique:users',
            'email' => 'required|email|max:100|unique:users',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password'
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'user',
            'password' => bcrypt($request->password)
        ]);

        Auth::loginUsingId($user->id);

        return redirect()->to($request['returnTo'])->with('toast_success', 'Welcome, ' . $request->name);
    }
}
