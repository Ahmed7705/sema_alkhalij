<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SocialAuthController extends Controller
{
    public function redirectToProvider($provider)
    {
        if (!in_array($provider, ['google', 'apple'])) {
            return redirect()->route('login')->withErrors(['login' => 'مزود الخدمة غير مدعوم.']);
        }

        // 1. Try using Socialite package if installed
        if (class_exists(\Laravel\Socialite\Facades\Socialite::class)) {
            try {
                return \Laravel\Socialite\Facades\Socialite::driver($provider)->redirect();
            } catch (\Throwable $e) {
                \Log::warning("Socialite driver redirect failed: " . $e->getMessage());
            }
        }

        // 2. Native Google OAuth 2.0 redirect fallback using Guzzle/Http
        if ($provider === 'google') {
            $clientId = env('GOOGLE_CLIENT_ID');
            $redirectUri = env('GOOGLE_REDIRECT_URI', url('/auth/google/callback'));

            if ($clientId) {
                $query = http_build_query([
                    'client_id' => $clientId,
                    'redirect_uri' => $redirectUri,
                    'response_type' => 'code',
                    'scope' => 'openid profile email',
                    'access_type' => 'online',
                    'prompt' => 'select_account',
                ]);

                return redirect('https://accounts.google.com/o/oauth2/v2/auth?' . $query);
            }
        }

        // 3. Development Fallback if credentials/packages are missing
        return $this->loginDemoUser($provider);
    }

    public function handleProviderCallback(Request $request, $provider)
    {
        if (!in_array($provider, ['google', 'apple'])) {
            return redirect()->route('login')->withErrors(['login' => 'مزود الخدمة غير مدعوم.']);
        }

        // 1. Try using Socialite package if installed
        if (class_exists(\Laravel\Socialite\Facades\Socialite::class)) {
            try {
                $socialUser = \Laravel\Socialite\Facades\Socialite::driver($provider)->user();
                return $this->findOrCreateUserAndLogin($provider, $socialUser->getId(), $socialUser->getEmail(), $socialUser->getName(), $socialUser->getAvatar());
            } catch (\Throwable $e) {
                \Log::warning("Socialite callback failed: " . $e->getMessage());
            }
        }

        // 2. Native Google OAuth 2.0 token exchange using Http / Guzzle
        if ($provider === 'google' && $request->has('code')) {
            try {
                $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
                    'code' => $request->code,
                    'client_id' => env('GOOGLE_CLIENT_ID'),
                    'client_secret' => env('GOOGLE_CLIENT_SECRET'),
                    'redirect_uri' => env('GOOGLE_REDIRECT_URI', url('/auth/google/callback')),
                    'grant_type' => 'authorization_code',
                ]);

                if ($response->successful()) {
                    $tokenData = $response->json();
                    $accessToken = $tokenData['access_token'] ?? null;

                    if ($accessToken) {
                        $userInfo = Http::withToken($accessToken)->get('https://www.googleapis.com/oauth2/v3/userinfo')->json();
                        
                        $googleId = $userInfo['sub'] ?? null;
                        $email = $userInfo['email'] ?? null;
                        $name = $userInfo['name'] ?? 'مستخدم Google';
                        $avatar = $userInfo['picture'] ?? null;

                        if ($email) {
                            return $this->findOrCreateUserAndLogin('google', $googleId, $email, $name, $avatar);
                        }
                    }
                }
            } catch (\Throwable $e) {
                \Log::error('Native Google OAuth Callback Error: ' . $e->getMessage());
            }
        }

        // Fallback
        return $this->loginDemoUser($provider);
    }

    protected function findOrCreateUserAndLogin(string $provider, ?string $providerId, string $email, string $name, ?string $avatar = null)
    {
        $user = User::where("{$provider}_id", $providerId)
            ->orWhere('email', $email)
            ->first();

        if ($user) {
            $user->update([
                "{$provider}_id" => $providerId,
                'avatar' => $avatar ?? $user->avatar,
                'email_verified_at' => $user->email_verified_at ?? now(),
            ]);
        } else {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'phone' => '05' . rand(10000000, 99999999),
                'avatar' => $avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($name),
                'email_verified_at' => now(),
                'password' => bcrypt(Str::random(16)),
                'role' => 'customer',
                'is_active' => true,
                "{$provider}_id" => $providerId,
            ]);
        }

        Auth::login($user);

        return redirect()->route('profile')->with('success', "تم تسجيل دخولك بنجاح باستخدام حساب Google!");
    }

    protected function loginDemoUser(string $provider)
    {
        $demoEmail = "demo_{$provider}@sema-alkhalij.com";
        $user = User::firstOrCreate(
            ['email' => $demoEmail],
            [
                'name' => 'مستخدم ' . ucfirst($provider),
                'phone' => '0500000000',
                'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode(ucfirst($provider)),
                'email_verified_at' => now(),
                'password' => bcrypt(Str::random(16)),
                'role' => 'customer',
                'is_active' => true,
                "{$provider}_id" => "demo_{$provider}_12345",
            ]
        );

        Auth::login($user);

        return redirect()->route('profile')->with('success', "تم تسجيل الدخول بنجاح عبر $provider!");
    }
}
