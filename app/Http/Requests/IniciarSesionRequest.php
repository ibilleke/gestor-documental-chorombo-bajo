<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class IniciarSesionRequest extends FormRequest
{
    /**
     * Intentos fallidos permitidos por minuto para un mismo correo e IP.
     */
    public const MAXIMO_INTENTOS = 5;

    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Valida las credenciales y que la cuenta esté activa, con límite de intentos.
     *
     * @throws ValidationException
     */
    public function autenticar(): User
    {
        $this->asegurarQueNoEsteBloqueado();

        $credenciales = $this->only('email', 'password');

        if (! Auth::validate($credenciales)) {
            RateLimiter::hit($this->claveLimite());

            throw ValidationException::withMessages(['email' => __('auth.failed')]);
        }

        RateLimiter::clear($this->claveLimite());

        /** @var User $usuario */
        $usuario = Auth::getLastAttempted();

        if (! $usuario->activo) {
            throw ValidationException::withMessages(['email' => __('auth.inactivo')]);
        }

        Auth::login($usuario);

        return $usuario;
    }

    /**
     * @throws ValidationException
     */
    private function asegurarQueNoEsteBloqueado(): void
    {
        if (! RateLimiter::tooManyAttempts($this->claveLimite(), self::MAXIMO_INTENTOS)) {
            return;
        }

        event(new Lockout($this));

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', ['seconds' => RateLimiter::availableIn($this->claveLimite())]),
        ]);
    }

    private function claveLimite(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
}
