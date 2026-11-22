<x-layouts.guest titulo="Iniciar sesión">
    <div class="w-full max-w-md rounded-xl border border-borde bg-white p-8">
        <div class="mx-auto mb-3 flex size-16 items-center justify-center rounded-full bg-marino text-xl font-bold text-white" aria-hidden="true">
            G733
        </div>
        <h1 class="text-center text-2xl font-semibold text-marino">Gestor Documental</h1>
        <p class="mb-6 text-center text-ayuda">
            Escuela Básica G733 Chorombo Bajo<br>
            Se ingresa con el correo y la contraseña entregados por Administración.
        </p>

        @if ($errors->any())
            <div class="mb-4 rounded-md border-l-4 border-error bg-error-fondo px-4 py-3 text-error" role="alert">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.store') }}" novalidate>
            @csrf

            <div class="mb-5">
                <label for="email" class="mb-1 block font-semibold">
                    Correo electrónico <span class="text-sm font-normal text-error">* (obligatorio)</span>
                </label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                    @error('email') aria-invalid="true" @enderror
                    class="min-h-11 w-full rounded-md border-[1.5px] border-[#9aaabb] bg-white px-3 py-2 focus:border-primario focus:outline-3 focus:outline-primario/40 aria-invalid:border-error">
                <p class="mt-1 text-sm text-ayuda">Ej.: nombre@ejemplo.cl</p>
            </div>

            <div class="mb-6">
                <label for="password" class="mb-1 block font-semibold">
                    Contraseña <span class="text-sm font-normal text-error">* (obligatorio)</span>
                </label>
                <input id="password" name="password" type="password" required autocomplete="current-password"
                    class="min-h-11 w-full rounded-md border-[1.5px] border-[#9aaabb] bg-white px-3 py-2 focus:border-primario focus:outline-3 focus:outline-primario/40">
            </div>

            <button type="submit"
                class="min-h-11 w-full rounded-md border-2 border-primario bg-primario px-5 py-2 font-semibold text-white hover:border-marino hover:bg-marino focus:outline-3 focus:outline-offset-2 focus:outline-primario">
                Iniciar sesión
            </button>
        </form>

        <p class="mt-5 text-center text-sm text-ayuda">¿Problemas para ingresar? Contactar a Administración.</p>
    </div>
</x-layouts.guest>
