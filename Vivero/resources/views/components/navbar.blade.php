@php
    $pref = Auth::user()?->preference;
    $navbarColor = $pref?->navbar_color ?? '#1F2937';
    $navbarTextColor = $pref?->navbar_text_color ?? '#FFFFFF';
    $logo = $pref?->logo_image ? asset('storage/logos/' . $pref->logo_image) : asset('/storage/images/logo.png');

    $publicLinks = [
        ['name' => 'Inicio', 'href' => '/'],
        ['name' => '¿Quiénes Somos?', 'href' => '/home#quienes-somos'],
        ['name' => 'Productos', 'href' => '/productos'],
        ['name' => 'Preguntas Frecuentes', 'href' => '/home#faq'],
        ['name' => 'Contacto', 'href' => '/home#contact'],
    ];
@endphp
<div x-data="{ drawerOpen: false, userdrawerOpen: false }">

<nav class="bg-[var(--navbar-color)] px-6 md:px-20 py-2 flex items-center justify-between font-roboto_condensed sticky top-0 z-50"
     x-data="{ menuOpen: false, userMenuOpen: false }"
     style="color: {{ $navbarTextColor }}">

    <!-- Logo -->
    <div class="flex-shrink-0">
        <img src="{{ $logo }}" alt="Logo" class="h-[80px] w-auto" loading="lazy" />
    </div>

    <!-- Links escritorio -->
    <ul class="hidden md:flex space-x-10 list-none" style="color: {{ $navbarTextColor }}">
        @if (request()->is('/') || request()->is('home') || request()->is('productos') || request()->is('faq') || request()->is('contacto'))
            @foreach ($publicLinks as $link)
                <li>
                    <a href="{{ $link['href'] }}" class="hover:opacity-80 transition duration-200" style="color: {{ $navbarTextColor }}">
                        {{ $link['name'] }}
                    </a>
                </li>
            @endforeach
        @else
            @can('ver dashboard')
                <li><a href="{{ route('dashboard') }}" class="hover:opacity-80" style="color: {{ $navbarTextColor }}">Dashboard</a></li>
            @endcan
            @can('gestionar usuarios')
                <li><a href="{{ route('users.index') }}" class="hover:opacity-80" style="color: {{ $navbarTextColor }}">Usuarios</a></li>
            @endcan
        @endif
    </ul>

    <!-- Botón login o menú de usuario -->
    <div class="relative hidden md:block" x-data="{ open: false }">
        @auth
            <button @click="open = !open" class="focus:outline-none flex items-center gap-2" style="color: {{ $navbarTextColor }}">
                <img src="{{ $pref?->profile_image ? asset('storage/profiles/' . $pref->profile_image) : asset('/dist/img/user2-160x160.jpg') }}"
                     alt="Perfil" class="h-8 w-8 rounded-full object-cover">
                <span>{{ Auth::user()->name }}</span>
            </button>
            <div x-show="open" @click.outside="open = false"
                class="absolute right-0 mt-2 w-48 rounded-md shadow-lg z-50"
                style="background-color: var(--navbar-color); color: var(--navbar-text-color);" x-cloak>
                @can('ver dashboard')
                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 hover:bg-opacity-20">Panel Admin</a>
                @endcan
                <a href="{{ route('preferences.index') }}" class="block px-4 py-2 hover:bg-opacity-20">Preferencias</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block px-4 py-2 w-full text-left hover:bg-opacity-20">Cerrar sesión</button>
                </form>
            </div>
        @else
            <a href="{{ route('login') }}">
                <img src="{{ asset('/storage/images/navlogin.svg') }}" alt="Login" class="h-[50px] w-auto" />
            </a>
        @endauth
    </div>

    <!-- Botón menú móvil -->
    <button @click="menuOpen = !menuOpen" class="md:hidden">
        <img src="{{ asset('/storage/images/list.svg') }}" alt="Menú" class="w-8 h-8" />
    </button>
</nav>

<!-- Menú móvil -->
<div x-show="menuOpen" x-transition class="md:hidden bg-[var(--navbar-color)] px-6 pt-4 pb-6 space-y-4 shadow-md" style="color: {{ $navbarTextColor }}" x-cloak>
    <ul class="space-y-2">
        @if (request()->is('/') || request()->is('home') || request()->is('productos') || request()->is('faq') || request()->is('contacto'))
            @foreach ($publicLinks as $link)
                <li>
                    <a href="{{ $link['href'] }}" class="block hover:opacity-80 text-lg" style="color: {{ $navbarTextColor }}">
                        {{ $link['name'] }}
                    </a>
                </li>
            @endforeach
        @else
            @auth
                <li><a href="{{ route('dashboard') }}" class="block hover:opacity-80 text-lg" style="color: {{ $navbarTextColor }}">Dashboard</a></li>
                <li><a href="{{ route('preferences.index') }}" class="block hover:opacity-80 text-lg" style="color: {{ $navbarTextColor }}">Preferencias</a></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block text-left w-full hover:opacity-80 text-lg" style="color: {{ $navbarTextColor }}">
                            Cerrar sesión
                        </button>
                    </form>
                </li>
            @endauth
        @endif
    </ul>
</div>

<style>[x-cloak] { display: none !important; }</style>
