<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
             //  TURNSTILE
        'cf-turnstile-response' => ['required'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
{
    $this->ensureIsNotRateLimited();

    //  VERIFY TURNSTILE DI SINI
    $response = \Illuminate\Support\Facades\Http::asForm()->post(
        'https://challenges.cloudflare.com/turnstile/v0/siteverify',
        [
            'secret' => config('services.turnstile.secret'),
            'response' => $this->input('cf-turnstile-response'),
            'remoteip' => $this->ip(),
        ]
    );

    if (! $response->json('success')) {
        throw ValidationException::withMessages([
            'email' => 'Verifikasi keamanan gagal. Silakan coba lagi.',
        ]);
    }

    //  BARU AUTH
    if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {

        sleep(1);

        \Log::warning('Login failed', [
            'email' => $this->input('email'),
            'ip' => $this->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        RateLimiter::hit($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.failed'),
        ]);
    }

    RateLimiter::clear($this->throttleKey());
}

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
    public function messages(): array
{
    return [
        'cf-turnstile-response.required' => 'Silakan verifikasi bahwa Anda bukan robot.',
    ];
}
}
