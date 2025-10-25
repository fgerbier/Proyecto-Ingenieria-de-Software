@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-10 p-6 bg-white shadow rounded">
    <h2 class="text-xl font-bold mb-4">Resumen de tu Compra</h2>

    <p>Total: ${{ number_format(session('cart') ? array_sum(array_map(fn($i) => $i['precio'] * $i['cantidad'], session('cart'))) : 0, 0, ',', '.') }}</p>

    <a href="{{ route('checkout.clear-cart') }}" class="block text-center w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 mt-4">
    Volver al Inicio
    </a>

</div>
@endsection

