<!-- resources/views/profile/partials/sidebar.blade.php -->
<div class="w-64 flex-shrink-0 text-white {{ $fontSize }}" style="background-color: {{ $accentColor }};" :class="{'-ml-64': !sidebarOpen}">
  <div class="p-4 border-b border-white/20">
    <div class="flex items-center space-x-2">
      <img src="{{ $logo }}" alt="Logo" class="h-10 w-10 rounded-full object-cover">
      <span class="text-lg font-semibold">Panel de Administración</span>
    </div>
  </div>
  <div class="p-4 border-b border-white/20">
    <div class="flex items-center space-x-3">
      <img src="{{ asset('storage/profiles/' . (Auth::user()->preference->profile_image ?? 'user2-160x160.jpg')) }}" alt="User" class="h-10 w-10 rounded-full object-cover">
      <div>
        <div class="font-medium">{{ Auth::user()->name }}</div>
        <div class="text-white text-sm">Administrador</div>
      </div>
    </div>
  </div>

  <nav class="p-4">
    <ul>
      <li class="mb-1">
        <a href="{{ route('home') }}" class="flex items-center space-x-2 px-3 py-2 bg-white/10 hover:bg-white/20 rounded-md">
          <i class="fa-solid fa-gauge"></i>
          <span>Catálogo</span>
        </a>
      </li>
      <li class="mb-1">
        <a href="{{ route('ingresos') }}" class="flex items-center space-x-2 px-3 py-2 bg-white/10 hover:bg-white/20 rounded-md">
          <i class="fa-regular fa-circle-user"></i>
          <span>Ingresos</span>
        </a>
      </li>
    </ul>
  </nav>
</div>
