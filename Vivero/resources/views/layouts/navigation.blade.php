@php
    $preferences = auth()->user()?->preference;
    $logo = $preferences?->logo_image ?? null;
    $profile = $preferences?->profile_image ?? null;
@endphp

<nav x-data="{ open: false }" class="border-b border-gray-100 dark:border-gray-700 bg-[var(--navbar-color)] text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center">
                    @if ($logo)
                        <img src="{{ asset('storage/logos/' . $logo) }}" alt="Logo" class="h-10 w-auto object-contain">
                    @else
                        <img src="{{ asset('storage/images/logo-removebg.png') }}" alt="Logo" class="h-10 w-auto">
                    @endif
                </a>

                <!-- Navigation Links -->
                <div class="hidden space-x-6 sm:flex sm:ml-10">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">Inicio</x-nav-link>
                    <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')">Productos</x-nav-link>
                    <x-nav-link href="{{ route('about') }}">Nosotros</x-nav-link>
                    <x-nav-link href="{{ route('contact') }}">Contacto</x-nav-link>
                    <x-nav-link href="{{ route('faq') }}">Preguntas frecuentes</x-nav-link>
                </div>
            </div>

            <!-- Right Side -->
            <div class="hidden sm:flex sm:items-center">
                @auth
                    <!-- Shopping Cart Icon -->
                    <a href="{{ route('cart.index') }}" class="mr-4 text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M3 3h2l.4 2M7 13h10l4-8H5.4" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="9" cy="21" r="1" />
                            <circle cx="20" cy="21" r="1" />
                        </svg>
                    </a>

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 text-sm rounded-md text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none">
                                @if ($profile)
                                    <img src="{{ asset('storage/profiles/' . $profile) }}" alt="Perfil" class="h-8 w-8 rounded-full object-cover mr-2">
                                @endif
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ml-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0L5.293 8.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">Perfil</x-dropdown-link>
                            @can('ver dashboard')
                                <x-dropdown-link :href="route('dashboard')">Panel Admin</x-dropdown-link>
                            @endcan
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                    Cerrar sesión
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-300 hover:underline mr-4">Iniciar sesión</a>
                    <a href="{{ route('register') }}" class="text-sm text-gray-700 dark:text-gray-300 hover:underline">Registrarse</a>     
                @endauth
            </div>

            <!-- Mobile Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = !open" class="p-2 text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 rounded-md">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="sm:hidden hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">Inicio</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')">Productos</x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('about') }}">Nosotros</x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('contact') }}">Contacto</x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('faq') }}">Preguntas frecuentes</x-responsive-nav-link>
        </div>

        @auth
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">Perfil</x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Cerrar sesión</x-responsive-nav-link>
                </form>
            </div>
        </div>
        @endauth
    </div>
</nav>
