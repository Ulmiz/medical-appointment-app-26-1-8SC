<x-admin-layout title="Calendario" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Calendario',
    ],
]">

    <div class="p-6 bg-white rounded-lg shadow border border-gray-100">
        <div class="flex justify-between items-center mb-6 border-b pb-4">
            <h2 class="text-xl font-semibold text-gray-800">Calendario de Citas</h2>
            <a href="{{ route('admin.appointments.create') }}" class="px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-white rounded-lg transition shadow-sm font-medium">
                + Nueva Cita
            </a>
        </div>

        <!-- Calendario FullCalendar -->
        <div id="calendar" class="mt-4"></div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                buttonText: {
                    today: 'Hoy',
                    month: 'Mes',
                    week: 'Semana',
                    day: 'Día',
                    list: 'Lista'
                },
                events: @json($events),
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    meridiem: false,
                    hour12: false
                },
                displayEventTime: false // Ocultamos el tiempo nativo porque ya lo pusimos en el title
            });
            calendar.render();
        });
    </script>
    @endpush

</x-admin-layout>
