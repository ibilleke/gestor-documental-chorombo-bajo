<x-layouts.app titulo="Inicio">
    <h1 class="mb-2 text-2xl font-semibold text-marino">Inicio</h1>
    <p class="text-ayuda">Sesión iniciada como {{ auth()->user()->name }}.</p>
    {{-- Las tarjetas por rol del panel se incorporan en la Fase 2 (DESIGN §5.2) --}}
</x-layouts.app>
