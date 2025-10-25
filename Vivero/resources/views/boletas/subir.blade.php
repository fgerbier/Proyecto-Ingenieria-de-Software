@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-lg p-6 bg-white shadow rounded mt-10">
    <h2 class="text-xl font-bold mb-4 text-center">Subir Boleta PDF</h2>

    <form action="{{ route('boletas.guardar', $pedido->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 mb-2" for="boleta_pdf">Selecciona PDF:</label>
            <input type="file" name="boleta_pdf" id="boleta_pdf"
                   class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500">
            @error('boleta_pdf')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit"
                class="w-full bg-indigo-500 hover:bg-indigo-600 text-white py-2 px-4 rounded shadow transition">
            Subir Boleta
        </button>
    </form>
</div>
@endsection
