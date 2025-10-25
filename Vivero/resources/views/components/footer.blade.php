@php
    $pref = Auth::user()?->preference;
    $accentColor = $accentColor ?? ($pref?->accent_color ?? '#10B981');
    $logo = $logo ?? ($pref?->logo_image ? asset('storage/logos/' . $pref->logo_image) : asset('dist/img/logoeditha.png'));
@endphp

<footer class="text-white" style="background-color: {{ $accentColor }};">
    <div class="max-w-screen-xl mx-auto px-6 py-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <img src="{{ $logo }}" class="h-20 mb-3" alt="Logo Plantas Editha">
                <span class="text-sm">Vivero de calidad, naturaleza con amor.</span>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-2">¿Quiénes Somos?</h3>
                <ul class="space-y-1 text-sm">
                    <li><a href="/home#quienes-somos" class="hover:underline">Nosotros</a></li>
                    <li><a href="/home#mision" class="hover:underline">Misión y Visión</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-2">Legal</h3>
                <ul class="space-y-1 text-sm">
                    <li><a href="{{ route('politicas') }}" class="hover:underline">Políticas de Privacidad</a></li>
                    <li><a href="{{ route('terminos') }}" class="hover:underline">Términos y Condiciones</a></li>
                </ul>
            </div>
        </div>
        <div class="text-center text-xs text-gray-100 mt-6 border-t border-white pt-4">
            © {{ date('Y') }} Plantas Editha. Todos los derechos reservados.
        </div>
    </div>
</footer>
