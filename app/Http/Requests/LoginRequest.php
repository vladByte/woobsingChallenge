<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'correo' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    public function authenticate(): void{

        $this->ensureIsNotRateLimited();

        if (! Auth::attempt($this->only('correo', 'password'), $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'correo' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());

        if( $this->ip() === "127.0.0.1" && Auth::user()->id_rol === 1 )
            Cookie::queue('origin_sesion', Auth::user()->id_rol.'||'.$this->ip(), 30 );
    }

    
}
