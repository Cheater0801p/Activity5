<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except([
            'showLogin', 'handleLogin', 'showRegister', 'handleRegister', 
            'redirectToGoogle', 'handleGoogleCallback', 'redirectToFacebook', 'handleFacebookCallback'
        ]);
    }

    public function showLogin() {
        return view('auth.login');
    }

    public function showRegister() {
        return view('auth.register');
    }

    public function handleLogin(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt($credentials)) {
            return redirect()->route('dashboard');
        }

        return back()->with('error', 'Invalid login credentials.');
    }

    public function handleRegister(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
        $user = new User();
        $user->first_name = $request->first_name;
        $user->middle_name = $request->middle_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
       if ( $user->save()) {
            return redirect()->route('register')->with('success', 'Registration successful!');
        }
        return back()->with('error', 'Registration failed.');
        
    }

    public function redirectToGoogle() {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback() {
        $socialUser = Socialite::driver('google')->user();
        $this->createOrUpdateUser($socialUser, 'google');
        return redirect()->route('dashboard');
    }

    public function redirectToFacebook() {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback() {
        $socialUser = Socialite::driver('facebook')->user();
        $this->createOrUpdateUser($socialUser, 'facebook');
        return redirect()->route('dashboard');
    }

    private function createOrUpdateUser($socialUser, $provider) {
        $user = User::updateOrCreate(
            ['email' => $socialUser->getEmail()],
            [
                'first_name' => explode(' ', $socialUser->getName())[0] ?? $socialUser->getName(),
                'last_name' => explode(' ', $socialUser->getName())[1] ?? '',
                'password' => Hash::make(Str::random(32)),
            ]
        );

        Auth::login($user);
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('login');
    }

}
