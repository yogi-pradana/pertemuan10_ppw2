<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;



class LoginRegisterController extends Controller
{

    public function register()
    {
        return view('auth.register');
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name'      =>'required|string|max:250',
    //         'email'     =>'required|email|max:250|unique:users',
    //         'password'  => 'required|min:8|confirmed',
    //     ]);

    //     User::create([
    //         'name'      => $request->name,
    //         'email'     => $request->email,
    //         'password'  => Hash::make($request->password),
    //     ]);

    //     $credentials = $request->only('email', 'password');
    //     Auth::attempt($credentials);
    //     $request->session()->regenerate();
    //     return redirect()->route('dashboard')
    //         ->with('Registration successful. You can now log in.');
    // }

    public function store(Request $request)
{
   

    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'role' => 'required|in:user,admin', // validasi role
        'photo' => 'image|nullable|max:1999'
    ]);

    if ($request->hasFile('photo')) {
        $filenameWithExt = $request->file('photo')->getClientOriginalName();
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension = $request->file('photo')->getClientOriginalExtension();
        $filenameSimpan = $filename . '_' . time() . '.' . $extension;
        $path = $request->file('photo')->storeAs('photos', $filenameSimpan);
    } else {
        $path = null;
    }

    $user = new User();
    $user->name = $validatedData['name'];
    $user->email = $validatedData['email'];
    $user->password = bcrypt($validatedData['password']);
    $user->level = $validatedData['role']; // simpan nilai role ke kolom level
    $user->photo = $path;
    $user->save();

    Mail::to($user->email)->send(new SendEmail($user));

    return redirect()->route('login')->with('success', 'Registration successful. Please log in.');
}



    public function login()
    {
        return view('auth.login');
    }

    // public function authenticate(Request $request)
    // {
    //     $credentials = $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required'
    //     ]);

    //     if (Auth::attempt($credentials)) {
    //         $request->session()->regenerate();
    //         return redirect()->route('dashboard')
    //             ->withSuccess('You have successfully logged in!');
    //     }

    //     return back()->withErrors([
    //         'email' => 'Your provided credentials do not match our records.',
    //     ])->onlyInput('email');
    // }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

        // Cek level pengguna
            if (Auth::user()->level === 'admin') {
                return redirect()->route('dashboard')->withSuccess('You have successfully logged in!');
            } else {
                Auth::logout();
                return redirect()->route('login')->withErrors([
                    'email' => 'You do not have permission to access the dashboard.'
                ]);
            }
        }

        return back()->withErrors([
            'email' => 'Your provided credentials do not match our records.',
        ])->onlyInput('email');
    }


    // public function dashboard()
    // {
    //     if (Auth::check()){
    //         return view('auth.dashboard');
    //     }

    //     return redirect()->route('login')
    //         ->withErrors([
    //             'email'=> 'Please login to acces the dashboard.',
    //         ])->onlyInput('email');
    // }

    public function dashboard()
    {
        if (Auth::check() && Auth::user()->level === 'admin') {
            return view('auth.dashboard');
        }

        return redirect()->route('login')->withErrors([
            'email' => 'Please login with an admin account to access the dashboard.'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')
            ->withSuccess('You have successfully logged out.');
    }
}

