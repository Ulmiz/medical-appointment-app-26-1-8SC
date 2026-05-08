<x-admin-layout title="Gestor de horarios" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Doctores',
        'href' => route('admin.doctors.index'),
    ],
    [
        'name' => 'Horarios',
    ],
]">

    <div class="p-6 bg-white rounded-lg shadow border border-gray-100">
        <div class="flex justify-between items-center mb-6 border-b pb-4">
            <h2 class="text-xl font-semibold text-gray-800">Gestor de horarios - {{ $doctor->name }}</h2>
            <button class="px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-white rounded-lg transition shadow-sm font-medium">
                Guardar horario
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="text-sm text-gray-500 border-b">
                    <tr>
                        <th class="py-3 px-4 font-semibold text-left">DÍA/HORA</th>
                        <th class="py-3 px-4 font-semibold text-center">LUNES</th>
                        <th class="py-3 px-4 font-semibold text-center">MARTES</th>
                        <th class="py-3 px-4 font-semibold text-center">MIÉRCOLES</th>
                        <th class="py-3 px-4 font-semibold text-center">JUEVES</th>
                        <th class="py-3 px-4 font-semibold text-center">VIERNES</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <!-- Hora 08:00:00 -->
                    <tr class="align-top">
                        <td class="py-6 px-4">
                            <div class="flex items-center">
                                <input type="checkbox" class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500 mr-2">
                                <span class="font-medium text-gray-800">08:00:00</span>
                            </div>
                        </td>
                        @foreach(['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'] as $day)
                            <td class="py-6 px-4">
                                <div class="flex flex-col space-y-3">
                                    <label class="flex items-center space-x-2 text-sm text-gray-600">
                                        <input type="checkbox" class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500">
                                        <span>Todos</span>
                                    </label>
                                    <label class="flex items-center space-x-2 text-sm text-gray-600">
                                        <input type="checkbox" checked class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500">
                                        <span>08:00 - 08:15</span>
                                    </label>
                                    <label class="flex items-center space-x-2 text-sm text-gray-600">
                                        <input type="checkbox" class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500">
                                        <span>08:15 - 08:30</span>
                                    </label>
                                    <label class="flex items-center space-x-2 text-sm text-gray-600">
                                        <input type="checkbox" class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500">
                                        <span>08:30 - 08:45</span>
                                    </label>
                                    <label class="flex items-center space-x-2 text-sm text-gray-600">
                                        <input type="checkbox" class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500">
                                        <span>08:45 - 09:00</span>
                                    </label>
                                </div>
                            </td>
                        @endforeach
                    </tr>

                    <!-- Hora 09:00:00 -->
                    <tr class="align-top">
                        <td class="py-6 px-4">
                            <div class="flex items-center">
                                <input type="checkbox" class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500 mr-2">
                                <span class="font-medium text-gray-800">09:00:00</span>
                            </div>
                        </td>
                        @foreach(['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'] as $day)
                            <td class="py-6 px-4">
                                <div class="flex flex-col space-y-3">
                                    <label class="flex items-center space-x-2 text-sm text-gray-600">
                                        <input type="checkbox" class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500">
                                        <span>Todos</span>
                                    </label>
                                    <label class="flex items-center space-x-2 text-sm text-gray-600">
                                        <input type="checkbox" class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500">
                                        <span>09:00 - 09:15</span>
                                    </label>
                                    <label class="flex items-center space-x-2 text-sm text-gray-600">
                                        <input type="checkbox" class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500">
                                        <span>09:15 - 09:30</span>
                                    </label>
                                    <label class="flex items-center space-x-2 text-sm text-gray-600">
                                        <input type="checkbox" class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500">
                                        <span>09:30 - 09:45</span>
                                    </label>
                                    <label class="flex items-center space-x-2 text-sm text-gray-600">
                                        <input type="checkbox" class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500">
                                        <span>09:45 - 10:00</span>
                                    </label>
                                </div>
                            </td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</x-admin-layout>
