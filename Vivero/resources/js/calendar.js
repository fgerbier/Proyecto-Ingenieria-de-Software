import { Calendar } from '@fullcalendar/core';
import esLocale from '@fullcalendar/core/locales/es';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';

document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');

    fetch('/calendar/events')
        .then(response => response.json())
        .then(events => {
            // 🔔 Mostrar alertas de trasplante
            events.forEach(event => {
                if (event.alert) {
                    mostrarToast(`🔔 Mañana hay un trasplante: ${event.title}`);
                }
            });

            const calendar = new Calendar(calendarEl, {
                plugins: [dayGridPlugin, interactionPlugin],
                locale: esLocale,
                initialView: 'dayGridMonth',
                events: events,
                selectable: true,
                buttonText: {
                    today: 'Hoy',
                    month: 'Mes',
                    week: 'Semana',
                    day: 'Día',
                    list: 'Lista'
                },
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,listMonth'
                },
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    meridiem: false,
                    hour12: false
                },
                dateClick(info) {
                    const title = prompt('Título del evento:');
                    const type = prompt('Tipo (siembra o trasplante):');
                    const producto_id = prompt('ID del producto:');

                    if (title && type && producto_id) {
                        fetch('/calendar/store', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                title,
                                type,
                                start_date: info.dateStr,
                                producto_id
                            })
                        }).then(() => calendar.refetchEvents());
                    }
                },
            });

            calendar.render();
        });

    // 🟡 Toast de alerta
    function mostrarToast(mensaje) {
        const toast = document.createElement('div');
        toast.className = 'fixed top-5 right-5 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded shadow z-50';
        toast.innerText = mensaje;

        document.body.appendChild(toast);

        setTimeout(() => {
            toast.remove();
        }, 5000);
    }
});
