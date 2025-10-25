@extends('layouts.home')
@section('title', 'Plantas Editha')
@section('description', 'Bienvenido a Plantas Editha, tu destino para plantas de interior y exterior. Descubre nuestra misión, visión y más.')

@section('content')
    @include('components.hero')
    @include('components.last-added')
    @include('components.quienes-somos')
    @include('components.mision-vision')
    @include('components.faq')
    @include('components.contact')
@endsection
