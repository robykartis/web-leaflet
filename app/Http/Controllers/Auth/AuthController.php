<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        $title = 'Login Page';
        return view('auth.login', compact('title'));
    }
    public function proses_login(Request $request)
    {
        // Validasi data masukan
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email cannot be empty!',
            'email.email' => 'Email must be a valid email address!',
            'password.required' => 'Password cannot be empty!',
        ]);

        // Jika validasi gagal, kembali dengan pesan kesalahan
        if ($validator->fails()) {
            toastr()->error('Email and password cannot be empty', 'ERROR', ['timeOut' => 5000]);
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        // Cek apakah email terdaftar dalam database
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            toastr()->error('Email you entered is not registered!', 'ERROR', ['timeOut' => 5000]);
            return redirect()->back();
        }
        // Jika email terdaftar, lakukan validasi password
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            toastr()->error('Password you entered is incorrect!', 'ERROR', ['timeOut' => 5000]);
            return redirect()->back();
        }
        $input = $request->all();
        if (auth()->attempt(array('email' => $input['email'], 'password' => $input['password']))) {
            if ($user = Auth::user()) {
                toastr()->success('Login successfully!', 'SUCCESS', ['timeOut' => 5000]);
                return redirect()->route('dashboard');
            }
        } else {
            return redirect()->route('auth.login')
                ->with('error', 'Email atau password tidak terdaftar');
        }
    }
    public function logout(Request $request)
    {
        $request->session()->flush();
        Auth::logout();
        toastr()->success('Logout successfully!', 'SUCCESS', ['timeOut' => 5000]);
        return Redirect('/');
    }
}
