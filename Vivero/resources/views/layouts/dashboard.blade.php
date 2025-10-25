<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Plantas Editha | Dashboard')</title>

  <script src="https://cdn.tailwindcss.com"></script>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Inter&family=Poppins&family=Montserrat&family=Open+Sans&family=Nunito&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Roboto+Condensed&family=Inter&family=Poppins&family=Montserrat&family=Open+Sans&display=swap" rel="stylesheet">
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

  @php
    $pref = Auth::user()?->preference;
    $accentColor = $pref?->accent_color ?? '#10B981';
    $tableHeaderColor = $pref?->table_header_color ?? '#A0C185';
    $backgroundColor = $pref?->background_color ?? '#F3F4F6';
    $fontClass = match($pref?->font ?? 'roboto') {
        'inter' => "font-['Inter']",
        'poppins' => "font-['Poppins']",
        'montserrat' => "font-['Montserrat']",
        'nunito' => "font-['Nunito']",
        'opensans' => "font-['Open Sans']",
        default => "font-['Roboto']",
    };

    $bgImage = $pref?->background_image
        ? "background-image: url('" . asset('storage/backgrounds/' . $pref->background_image) . "'); background-size: cover;"
        : "background-color: {$backgroundColor};";
    $themeMode = $pref?->theme_mode ?? 'light';
    $fontSize = $pref?->font_size ?? 'text-base';
    $seccion = 'Panel de Administración';
    $logo = $pref?->logo_image ? asset('storage/logos/' . $pref->logo_image) : asset('dist/img/logoeditha.png');
    $profile = $pref?->profile_image ? asset('storage/profiles/' . $pref->profile_image) : asset('dist/img/user2-160x160.jpg');
    $isDark = $themeMode === 'dark' || ($themeMode === 'auto' && request()->cookie('prefers_dark') === 'true');
  @endphp

  @if ($themeMode === 'auto')
    <script>
      if (!document.cookie.includes("prefers_dark")) {
        document.cookie = "prefers_dark=" + (window.matchMedia('(prefers-color-scheme: dark)').matches ? "true" : "false");
        location.reload();
      }
    </script>
  @endif

  <style>
    :root {
        --table-header-color: {{ $tableHeaderColor }};
        --table-header-text-color: {{ $pref?->table_header_text_color ?? '#FFFFFF' }};
        --navbar-color: {{ $pref?->navbar_color ?? '#1F2937' }};
    }

    .custom-table-header {
        background-color: var(--table-header-color);
        color: var(--table-header-text-color) !important;
    }

    .custom-border {
        border-color: var(--table-header-color);
        border-width: 1px;
        border-style: solid;
        border-radius: 8px;
    }

    .custom-border thead th,
    .custom-border tbody td {
        border-left: 1px solid var(--table-header-color);
        border-right: 1px solid var(--table-header-color);
    }

    .custom-border tr:last-child td {
        border-bottom: 1px solid var(--table-header-color);
    }

    .custom-border tr:not(:last-child) td {
        border-bottom: 1px solid #e5e7eb;
    }

    /* ✅ Corrige color del texto del sidebar */
    .sidebar, .sidebar * {
        color: white !important;
    }
  </style>
</head>
@stack('scripts')

<body class="{{ $isDark ? 'dark' : '' }} {{ $fontClass }} {{ $fontSize }} bg-gray-100"
      style="{{ $bgImage }}"
      x-data="dashboard">

  <div class="flex h-screen">
    {{-- SIDEBAR --}}
    <div class="w-64 flex-shrink-0 sidebar" style="background-color: {{ $accentColor }};" :class="{'-ml-64': !sidebarOpen}">
      <div class="p-4 border-b border-white">
        <div class="flex items-center space-x-2">
          <img src="{{ $logo }}" alt="Logo" class="h-20 w-20 rounded-full object-contain">
          <span class="text-lg font-semibold">{{ $seccion }}</span>
        </div>
      </div>
      <nav class="p-4 space-y-4" x-data="{ 
        panel: false, 
        comercial: false, 
        vivero: false, 
        admin: false 
      }">
        
        {{-- 🔝 Accesos directos fijos --}}
        <ul class="space-y-1 font-medium">
          <li>
            <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded hover:bg-white hover:text-black transition">
              <i class="fa-solid fa-gauge-high mr-2"></i>Dashboard General
            </a>
          </li>
          <li>
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded hover:bg-white hover:text-black transition">
              <i class="fa-solid fa-house mr-2"></i>Página Principal
            </a>
          </li>
        </ul>

        {{-- 🔽 Menú agrupado por secciones --}}
        <ul class="space-y-1 font-medium">

          {{-- 📊 Panel Principal --}}
          <li>
            <button @click="panel = !panel" class="w-full flex justify-between items-center px-3 py-2 rounded hover:bg-white hover:text-black transition">
              <span><i class="fa-solid fa-chart-line mr-2"></i>Panel Principal</span>
              <i :class="panel ? 'fa fa-chevron-up' : 'fa fa-chevron-down'"></i>
            </button>
            <div x-show="panel" x-collapse>
              <ul class="ml-4 space-y-1 mt-1">
                @can('ver dashboard')
                  <li><a href="{{ route('dashboard.cotizaciones.index') }}" class="block px-3 py-2 rounded hover:bg-white hover:text-black transition"><i class="fa-solid fa-cash-register mr-2"></i>Cotizaciones</a></li>
                  <li><a href="{{ route('maintenance.index') }}" class="block px-3 py-2 rounded hover:bg-white hover:text-black transition"><i class="fa-solid fa-tools mr-2"></i>Mantenimiento</a></li>
                @endcan
                @can('ver calendario')
                  <li><a href="{{ route('simple_calendar.index') }}" class="block px-3 py-2 rounded hover:bg-white hover:text-black transition"><i class="fa fa-calendar-alt mr-2"></i>Calendario</a></li>
                @endcan
              </ul>
            </div>
          </li>

          {{-- 🛍️ Gestión Comercial --}}
          <li>
            <button @click="comercial = !comercial" class="w-full flex justify-between items-center px-3 py-2 rounded hover:bg-white hover:text-black transition">
              <span><i class="fa-solid fa-store mr-2"></i>Gestión Comercial</span>
              <i :class="comercial ? 'fa fa-chevron-up' : 'fa fa-chevron-down'"></i>
            </button>
            <div x-show="comercial" x-collapse>
              <ul class="ml-4 space-y-1 mt-1">
                @can('gestionar catálogo')
                  <li><a href="{{ route('dashboard.catalogo') }}" class="block px-3 py-2 rounded hover:bg-white hover:text-black transition"><i class="fa-solid fa-seedling mr-2"></i>Catálogo</a></li>
                @endcan
                @can('gestionar pedidos')
                  <li><a href="{{ route('pedidos.index') }}" class="block px-3 py-2 rounded hover:bg-white hover:text-black transition"><i class="fa-solid fa-box-open mr-2"></i>Pedidos</a></li>
                @endcan
                @can('gestionar descuentos')
                  <li><a href="{{ route('dashboard.descuentos') }}" class="block px-3 py-2 rounded hover:bg-white hover:text-black transition"><i class="fa-solid fa-tags mr-2"></i>Descuentos</a></li>
                @endcan
                @can('gestionar proveedores')
                  <li><a href="{{ route('proveedores.index') }}" class="block px-3 py-2 rounded hover:bg-white hover:text-black transition"><i class="fa-solid fa-truck-field mr-2"></i>Proveedores</a></li>
                @endcan
                @can('gestionar finanzas')
                  <li><a href="{{ route('dashboard.finanzas') }}" class="block px-3 py-2 rounded hover:bg-white hover:text-black transition"><i class="fa-solid fa-coins mr-2"></i>Finanzas</a></li>
                @endcan
              </ul>
            </div>
          </li>

          {{-- 🌱 Gestión del Vivero --}}
          <li>
            <button @click="vivero = !vivero" class="w-full flex justify-between items-center px-3 py-2 rounded hover:bg-white hover:text-black transition">
              <span><i class="fa-solid fa-leaf mr-2"></i>Gestión del Vivero</span>
              <i :class="vivero ? 'fa fa-chevron-up' : 'fa fa-chevron-down'"></i>
            </button>
            <div x-show="vivero" x-collapse>
              <ul class="ml-4 space-y-1 mt-1">
                @can('gestionar cuidados')
                  <li><a href="{{ route('dashboard.cuidados') }}" class="block px-3 py-2 rounded hover:bg-white hover:text-black transition"><i class="fa-solid fa-sun mr-2"></i>Cuidados</a></li>
                @endcan
                @can('gestionar fertilizantes')
                  <li><a href="{{ route('dashboard.fertilizantes') }}" class="block px-3 py-2 rounded hover:bg-white hover:text-black transition"><i class="fa-solid fa-person-digging mr-2"></i>Fertilizante</a></li>
                @endcan
                @can('gestionar insumos')
                  <li><a href="{{ route('dashboard.insumos') }}" class="block px-3 py-2 rounded hover:bg-white hover:text-black transition"><i class="fa-solid fa-droplet mr-2"></i>Insumos</a></li>
                @endcan
                @can('gestionar tareas')
                  <li><a href="{{ route('works.index') }}" class="block px-3 py-2 rounded hover:bg-white hover:text-black transition"><i class="fa-solid fa-list-check mr-2"></i>Tareas</a></li>
                @endcan
                @can('gestionar produccion')
                  <li><a href="{{ route('produccion.index') }}" class="block px-3 py-2 rounded hover:bg-white hover:text-black transition"><i class="fa-solid fa-seedling mr-2"></i>Producción</a></li>
                @endcan
              </ul>
            </div>
          </li>
          {{-- 🧑‍💼 Administración --}}
          <li>
            <button @click="admin = !admin" class="w-full flex justify-between items-center px-3 py-2 rounded hover:bg-white hover:text-black transition">
              <span><i class="fa-solid fa-user-gear mr-2"></i>Administración</span>
              <i :class="admin ? 'fa fa-chevron-up' : 'fa fa-chevron-down'"></i>
            </button>
            <div x-show="admin" x-collapse>
              <ul class="ml-4 space-y-1 mt-1">
                @can('ver roles')
                  <li><a href="{{ route('roles.index') }}" class="block px-3 py-2 rounded hover:bg-white hover:text-black transition"><i class="fa-solid fa-user-shield mr-2"></i>Roles</a></li>
                @endcan
                @can('gestionar usuarios')
                  <li><a href="{{ route('users.index') }}" class="block px-3 py-2 rounded hover:bg-white hover:text-black transition"><i class="fa-solid fa-users mr-2"></i>Usuarios</a></li>
                @endcan
                @can('ver panel soporte')
                  <li><a href="{{ route('clients.index') }}" class="block px-3 py-2 rounded hover:bg-white hover:text-black transition"><i class="fa-solid fa-building mr-2"></i>Clientes</a></li>
                @endcan
              </ul>
            </div>
          </li>
        </ul>
      </nav>
    </div>
    {{-- MAIN --}}
    <div class="flex-1 flex flex-col overflow-hidden">
      <header class="shadow-sm text-white" style="background-color: {{ $accentColor }};">

        <div class="flex items-center justify-between px-6 py-3">
          <div class="flex items-center">
            <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 dark:text-gray-100 focus:outline-none lg:hidden">
              <i class="fas fa-bars"></i>
            </button>
            <h1 class="ml-4 text-2xl font-['Roboto_Condensed'] font-bold text-black dark:text-white tracking-wide">
              @yield('title', 'Dashboard')
            </h1>
          </div>
          <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
              <img src="{{ $profile }}" alt="User" class="h-8 w-8 rounded-full object-cover">
              <span class="hidden md:inline">{{ Auth::user()->name }}</span>
            </button>
            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 rounded-md shadow-lg z-50"
                style="background-color: {{ $accentColor }};">
                <a href="#" class="block px-4 py-2 text-sm text-white hover:bg-opacity-90">Perfil</a>

                @can('ver dashboard')
                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-white hover:bg-opacity-90">Panel Admin</a>
                @endcan

                <a href="{{ route('preferences.index') }}" class="block px-4 py-2 text-sm text-white hover:bg-opacity-90">Personalización</a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-white hover:bg-opacity-90">
                        Cerrar sesión
                    </button>
                </form>
            </div>
          </div>
        </div>
      </header>

      <main class="flex-1 overflow-y-auto p-6">
        @if (Auth::user()?->must_change_password)
          <div class="mb-6 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 p-4 rounded shadow-md">
            ⚠️ <strong>Debes cambiar tu contraseña</strong> antes de continuar usando el sistema.
          </div>
        @endif
        @yield('content')
      </main>
    </div>
  </div>

  <script>
    document.addEventListener('alpine:init', () => {
      Alpine.data('dashboard', () => ({
        sidebarOpen: true,
        init() {
          this.handleResize();
          window.addEventListener('resize', this.handleResize.bind(this));
        },
        handleResize() {
          this.sidebarOpen = window.innerWidth >= 1024;
        }
      }));
    });
  </script>
</body>
</html>
