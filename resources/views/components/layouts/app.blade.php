@props(['titulo'])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $titulo }} · {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-fondo font-sans text-base text-texto">
    <header class="bg-marino text-white">
        <div class="flex flex-wrap items-center justify-between gap-3 px-6 py-3">
            <span class="font-semibold">Gestor Documental · Escuela Básica G733 Chorombo Bajo</span>

            <div class="flex flex-wrap items-center gap-4 text-sm">
                <span>
                    {{ auth()->user()->name }}
                    <span class="text-white/80">({{ auth()->user()->roles->pluck('nombre')->join(', ') }})</span>
                </span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="min-h-9 rounded-md border-2 border-white px-3 font-semibold hover:bg-white hover:text-marino focus:outline-3 focus:outline-offset-2 focus:outline-white">
                        Cerrar sesión
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-6xl px-6 py-8">
        {{ $slot }}
    </main>
</body>
</html>
