@extends('layouts.dashboard')

@section('title', 'Personalizar Tema')

@section('content')
<div class="p-6 max-w-4xl mx-auto font-['Roboto'] text-gray-800">

    <form action="{{ route('theme.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        {{-- 🎨 Estilo de colores --}}
        <div>
            <h2 class="text-lg font-semibold mb-4">Colores del tema</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div>
                    <label class="block font-semibold mb-1">Color de acento</label>
                    <input type="color" name="accent_color" value="{{ $preferences->accent_color ?? '#10B981' }}" class="w-16 h-10 border rounded">
                </div>

                <div>
                    <label class="block font-semibold mb-1">Color de fondo</label>
                    <input type="color" name="background_color" value="{{ $preferences->background_color ?? '#F3F4F6' }}" class="w-16 h-10 border rounded">
                </div>

                <div>
                    <label class="block font-semibold mb-1">Color del encabezado de tablas</label>
                    <input type="color" name="table_header_color" value="{{ $preferences->table_header_color ?? '#D1D5DB' }}" class="w-16 h-10 border rounded">
                </div>

                <div>
                    <label class="block font-semibold mb-1">Color de la barra de navegación</label>
                    <input type="color" name="navbar_color" value="{{ $preferences->navbar_color ?? '#1F2937' }}" class="w-16 h-10 border rounded">
                </div>

                <div>
                    <label class="block font-semibold mb-1">Color del texto de la navbar</label>
                    <input type="color" name="navbar_text_color" value="{{ $preferences->navbar_text_color ?? '#FFFFFF' }}" class="w-16 h-10 border rounded">
                </div>
            </div>
        </div>

        {{-- 🔤 Tipografía --}}
        <div>
            <h2 class="text-lg font-semibold mb-4">Tipografía</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block font-semibold mb-1">Fuente</label>
                    <select name="font" class="border rounded px-3 py-2 w-full">
                        <option value="roboto" {{ ($preferences->font ?? '') === 'roboto' ? 'selected' : '' }}>Roboto</option>
                        <option value="inter" {{ ($preferences->font ?? '') === 'inter' ? 'selected' : '' }}>Inter</option>
                        <option value="poppins" {{ ($preferences->font ?? '') === 'poppins' ? 'selected' : '' }}>Poppins</option>
                        <option value="montserrat" {{ ($preferences->font ?? '') === 'montserrat' ? 'selected' : '' }}>Montserrat</option>
                        <option value="nunito" {{ ($preferences->font ?? '') === 'nunito' ? 'selected' : '' }}>Nunito</option>
                        <option value="opensans" {{ ($preferences->font ?? '') === 'opensans' ? 'selected' : '' }}>Open Sans</option>
                    </select>
                </div>

                <div>
                    <label class="block font-semibold mb-1">Tamaño de fuente</label>
                    <select name="font_size" class="border rounded px-3 py-2 w-full">
                        <option value="text-sm" {{ ($preferences->font_size ?? '') === 'text-sm' ? 'selected' : '' }}>Pequeña</option>
                        <option value="text-base" {{ ($preferences->font_size ?? '') === 'text-base' ? 'selected' : '' }}>Normal</option>
                        <option value="text-lg" {{ ($preferences->font_size ?? '') === 'text-lg' ? 'selected' : '' }}>Grande</option>
                        <option value="text-xl" {{ ($preferences->font_size ?? '') === 'text-xl' ? 'selected' : '' }}>Extra grande</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- 🖼 Imágenes --}}
        <div>
            <h2 class="text-lg font-semibold mb-4">Imágenes</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Logo --}}
                <div>
                    <label class="block font-semibold mb-1">Logo del cliente</label>
                    <input type="file" name="logo_image" class="border px-3 py-2 rounded w-full">
                    @if ($preferences?->logo_image)
                        <div class="mt-2 relative">
                            <img src="{{ asset('storage/logos/' . $preferences->logo_image) }}" class="w-32 h-auto object-contain rounded shadow">
                        </div>
                    @endif
                </div>

                {{-- Perfil --}}
                <div>
                    <label class="block font-semibold mb-1">Foto de perfil</label>
                    <input type="file" name="profile_image" class="border px-3 py-2 rounded w-full">
                    @if ($preferences?->profile_image)
                        <div class="mt-2 relative">
                            <img src="{{ asset('storage/profiles/' . $preferences->profile_image) }}" class="w-20 h-20 object-cover rounded-full shadow">
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ✅ Botón Guardar --}}
        <div class="pt-4">
            <button type="submit"
                class="bg-[var(--table-header-color)] hover:opacity-90 text-white font-semibold px-6 py-2 rounded transition-colors">
                Guardar cambios
            </button>
        </div>
    </form>

    {{-- 🔴 Quitar imágenes --}}
    <div class="mt-6 flex flex-wrap gap-4">
        @if ($preferences?->logo_image)
        <form action="{{ route('theme.remove.logo') }}" method="POST">
            @csrf
            <button type="submit" class="bg-red-500 text-white px-4 py-1 rounded hover:bg-red-700 text-sm">
                Quitar logo
            </button>
        </form>
        @endif

        @if ($preferences?->profile_image)
        <form action="{{ route('theme.remove.profile') }}" method="POST">
            @csrf
            <button type="submit" class="bg-red-500 text-white px-4 py-1 rounded hover:bg-red-700 text-sm">
                Quitar perfil
            </button>
        </form>
        @endif
    </div>
</div>
@endsection
