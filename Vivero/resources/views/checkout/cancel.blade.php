@extends('layouts.home')

@section('title', 'Pago Cancelado')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&display=swap" rel="stylesheet">

<div class="max-w-md mx-auto mt-16 px-6 py-8 bg-white border border-red-100 shadow-md rounded-xl text-center" style="font-family: 'Roboto Condensed', sans-serif;">
    <div class="flex justify-center mb-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </div>

    <h2 class="text-xl font-bold text-red-600 mb-2">Pago Cancelado</h2>
    <p class="text-gray-700 mb-6">La transacción fue cancelada o no se pudo completar. Puedes revisar tu carrito e intentarlo nuevamente.</p>

    <a href="{{ route('cart.index') }}" class="inline-block px-5 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded transition">
        Volver al carrito
    </a>
</div>
@endsection

