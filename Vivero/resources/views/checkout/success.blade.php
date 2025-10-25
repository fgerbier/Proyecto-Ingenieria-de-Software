@extends('layouts.home')

@section('title', 'Pago Exitoso')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&display=swap" rel="stylesheet">

<div class="max-w-md mx-auto mt-12 px-6 py-8 bg-white shadow-md border border-green-100 rounded-xl text-center" style="font-family: 'Roboto Condensed', sans-serif;">
    <div class="flex justify-center mb-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
        </svg>
    </div>

    <h2 class="text-xl font-bold text-green-700 mb-2">¡Pago Exitoso!</h2>
    <p class="text-gray-700 mb-4">Gracias por tu compra. Hemos recibido tu pago correctamente.</p>

    <div class="bg-gray-50 border border-gray-200 rounded p-4 text-sm text-gray-800 mb-6">
        <strong>Código de autorización:</strong> {{ $response->getAuthorizationCode() }}
    </div>

    <a href="{{ route('home') }}" class="inline-block px-5 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded transition">
        Volver al inicio
    </a>
</div>
@endsection

