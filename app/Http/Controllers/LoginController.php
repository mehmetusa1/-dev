<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|string|max:100',
            'password' => 'required|string|max:200',
        ]);

        // Yalnızca .env içindeki admin hesabı giriş yapabilir.
        if (config('blog.username') && config('blog.password')
            && $data['username'] === config('blog.username')
            && hash_equals((string) config('blog.password'), $data['password'])) {
            Auth::logout();
            $request->session()->regenerate();
            $request->session()->put('admin', true);
            return redirect()->route('posts.index')->with('success', 'Giriş yapıldı.');
        }

        return back()->withErrors(['login' => 'Kullanıcı adı veya şifre yanlış.'])->withInput($request->only('username'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('posts.index')->with('success', 'Çıkış yapıldı.');
    }
}
