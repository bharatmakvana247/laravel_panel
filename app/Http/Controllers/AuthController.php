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
            return redirect()->route('admin.dashboard');
        } catch (\Exception $e) {
            smilify('error', 'User was Not Added.');
            return back();
        }
    }

    //Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $is_user = User::where('social_id', $user->id)->first();
            if (!empty($user->avatar)) {
                $filename = $user->id . '.png';
                Storage::disk('public')->put('userImage/' . $filename, file_get_contents($user->avatar));
            } else {
                $filename = 'default.png';
            }
            if (!$is_user) {
                $saveUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'user_type' => 'SuperAdmin',
                    'social_id' => $user->id,
                    'image' => $filename,
                    'social_media' => 'google',
                    'password' =>  Hash::make($user->name . '@' . $user->id)
                ]);
            } else {
                $saveUser = User::updateOrCreate([
                    'social_id' => $user->id,
                ], [
                    'name' => $user->name,
                    'email' => $user->email,
                    'user_type' => 'SuperAdmin',
                    'social_media' => 'google',
                    'image' => $filename,
                    'password' => Hash::make($user->name . '@' . $user->id)
                ]);
                $saveUser = User::where('social_id', $user->id)->first();
            }
            Auth::login($saveUser);
            return redirect()->route('admin.dashboard');
        } catch (\Throwable $th) {
            throw $th;
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
            $is_user = User::where('social_id', $user->id)->first();
            if (!empty($user->avatar)) {
                $filename = $user->id . '.png';
                Storage::disk('public')->put('userImage/' . $filename, file_get_contents($user->avatar));
            } else {
                $filename = 'default.png';
            }
            if (!$is_user) {
                $saveUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'user_type' => 'SuperAdmin',
                    'social_id' => $user->id,
                    'image' => $filename,
                    'social_media' => 'facebook',
                    'password' =>  Hash::make($user->name . '@' . $user->id)
                ]);
            } else {
                $saveUser = User::updateOrCreate([
                    'social_id' => $user->id,
                ], [
                    'name' => $user->name,
                    'email' => $user->email,
                    'user_type' => 'SuperAdmin',
                    'social_media' => 'facebook',
                    'image' => $filename,
                    'password' => Hash::make($user->name . '@' . $user->id)
                ]);
                $saveUser = User::where('social_id', $user->id)->first();
            }
            Auth::login($saveUser);
            return redirect()->route('admin.dashboard');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // Instagram Login
    public function instagramRedirect()
    {
        $appId = config('services.instagram.client_id');
        $redirectUri = urlencode(config('services.instagram.redirect'));
        return redirect()->to("https://api.instagram.com/oauth/authorize?app_id={$appId}&redirect_uri={$redirectUri}&scope=user_profile,user_media&response_type=code");
    }

    public function loginWithInstagram(Request $request)
    {
        $code = $request->code;
        if (empty($code)) return redirect()->route('home')->with('error', 'Failed to login with Instagram.');

        $appId = config('services.instagram.client_id');
        $secret = config('services.instagram.client_secret');
        $redirectUri = config('services.instagram.redirect');

        $client = new Client();

        // Get access token
        $response = $client->request('POST', 'https://api.instagram.com/oauth/access_token', [
            'form_params' => [
                'app_id' => $appId,
                'app_secret' => $secret,
                'grant_type' => 'authorization_code',
                'redirect_uri' => $redirectUri,
                'code' => $code,
            ]
        ]);

        if ($response->getStatusCode() != 200) {
            return redirect()->route('home')->with('error', 'Unauthorized login to Instagram.');
        }

        $content = $response->getBody()->getContents();
        $content = json_decode($content);

        $accessToken = $content->access_token;
        $userId = $content->user_id;

        // Get user info
        $response = $client->request('GET', "https://graph.instagram.com/me?fields=id,username,account_type&access_token={$accessToken}");

        $content = $response->getBody()->getContents();
        $oAuth = json_decode($content);

        // Get instagram user name
        $username = $oAuth->username;

        // do your code here
    }
}