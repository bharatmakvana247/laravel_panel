<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Storage;
use Helmesvs\Notify\Facades\Notify;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function welcome()
    {
        return view('welcome');
    }

    public function index()
    {
        return view('backend.pages.auth.login');
    }

    public function customLogin(Request $request)
    {
        $customMessages = [
            'email.required' => 'Please Enter Email.',
            'password.required' => 'Please Enter Password.',
        ];
        Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required|confirmed|min:6',
        ], $customMessages);
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            smilify('success', 'Welcome to Admin Panel. ⚡️');
            return redirect()->route('admin.dashboard');
        }
        smilify('error', 'Login details are not valid');
        return redirect()->route('admin.login');
    }

    public function register()
    {
        return view('backend.pages.auth.registration');
    }

    public function customRegister(Request $request)
    {
        $customMessages = [
            'username.required' => 'Please Enter Username.',
            'email.required' => 'Please Enter Email.',
            'password.required' => 'Please Enter Password.',
            'password.confirmed' => 'Password and Confirm Password is not matched.',
            'password_confirmation.required' => 'Please Enter Confirm Password.',
        ];
        $validatedData = Validator::make($request->all(), [
            'username' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required',
        ], $customMessages);

        if ($validatedData->fails()) {
            return redirect()->back()->withErrors($validatedData)->withInput();
        }

        try {
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                if ($file->isValid()) {
                    $extension = $file->getClientOriginalExtension();
                    $filename = $file->getClientOriginalName();
                    Storage::disk('public')->putFileAs('userImage', $file, $filename);
                }
            } else {
                $filename = 'default.png';
            }
            User::create([
                'name'   => $request->get('username'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
                'image' => $filename
            ]);
            return redirect()->route('admin.login');
        } catch (\Exception $e) {
            smilify('error', 'User was Not Added.');
            return back();
        }
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();

            $finduser = User::where('login_status', $user->id)->first();

            if ($finduser) {

                Auth::login($finduser);
                return redirect()->route('admin.dashboard');
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'password' => encrypt('123456dummy')
                ]);

                Auth::login($newUser);

                return redirect()->route('admin.dashboard');
            }
        } catch (Exception $e) {
            dd("Error", $e->getMessage());
        }
    }


    // Facebook Login
    public function facebookRedirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function loginWithFacebook()
    {
        try {

            $user = Socialite::driver('facebook')->user();
            $isUser = User::where('fb_id', $user->id)->first();

            if ($isUser) {
                Auth::login($isUser);
                return redirect('/dashboard');
            } else {
                $createUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'fb_id' => $user->id,
                    'password' => encrypt('admin@123')
                ]);

                Auth::login($createUser);
                return redirect('/dashboard');
            }
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }
}
