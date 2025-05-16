<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * توجيه المستخدم إلى Google OAuth
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * معالجة رد Google وإنشاء مستخدم جديد إذا لم يكن موجودًا
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::updateOrCreate(
                ['email' => $googleUser->getEmail()], // البحث باستخدام البريد الإلكتروني
                [
                    'name'        => $googleUser->getName(),
                    'provider'    => 'google',
                    'provider_id' => $googleUser->getId(),
                    'avatar'      => $googleUser->getAvatar(),
                    'password'    => bcrypt(uniqid()), // كلمة مرور عشوائية
                    'remember_token' => \Str::random(60),
                ]
            );

            Auth::login($user, true); // تسجيل الدخول مع تفعيل "تذكرني"

            return redirect()->route('dashboard')->with('success', 'تم تسجيل الدخول بنجاح باستخدام Google!');
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['error' => 'فشل تسجيل الدخول عبر Google، حاول مرة أخرى.']);
        }
    }

    /**
     * تسجيل الخروج
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'تم تسجيل الخروج بنجاح.');
    }
}
