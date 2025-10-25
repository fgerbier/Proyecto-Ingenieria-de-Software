@extends('layouts.dashboard')

@section('title', 'Calendario de Siembra y Trasplante')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/main.min.css" rel="stylesheet" />

<div class="px-4 py-6 font-['Roboto']">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold text-gray-800"></h2>
        <a href="{{ route('simple_calendar.create') }}"
        class="inline-flex items-center px-4 py-2 rounded text-white text-sm shadow"
        style="background-color: var(--table-header-color);">
        <i class="fas fa-plus mr-2"></i> Agregar evento
        </a>

    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded shadow">
            {{ session('success') }}
        </div>
    @endif

    <div id="calendar" class="bg-white rounded shadow p-4 text-sm"></div>
</div>
@endsection

@push('scripts')
<!-- FullCalendar y traducciones -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.11/locales-all.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    const eventos = @json($eventos);

    const calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'es',
        initialView: 'dayGridMonth',
        height: 'auto',
        events: eventos,
        dayMaxEventRows: true,
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,listMonth'
        },
        buttonText: {
            today: 'Hoy',
            month: 'Mes',
            week: 'Semana',
            day: 'Día',
            list: 'Lista'
        },
        eventClick: function(info) {
            const evento = info.event;
            const props = evento.extendedProps;

            const contenido = `
                <p><strong>Planta:</strong> ${props.planta ?? evento.title}</p>
                <p><strong>Cantidad:</strong> ${props.cantidad ?? 'No disponible'}</p>
                <p><strong>Fecha siembra:</strong> ${props.fecha_siembra ?? 'No registrada'}</p>
                <p><strong>Fecha trasplante:</strong> ${props.fecha_trasplante ?? 'No registrada'}</p>
                <p><strong>Días transcurridos:</strong> ${props.dias_transcurridos ?? 'No calculado'}</p>
                <p><strong>ID Plantín:</strong> ${props.plantin_id ?? 'Sin ID'}</p>
                <p><strong>Tipo:</strong> ${props.tipo}</p>
            `;

            Swal.fire({
                title: 'Detalle del Evento',
                html: contenido,
                icon: 'info',
                confirmButtonColor: '#16a34a'
            });
        }
    });

    calendar.render();
});
</script>
@endpush
