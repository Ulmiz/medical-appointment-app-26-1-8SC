<div>
<div class="max-w-6xl mx-auto space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">{{ $appointment->patient->name ?? ($appointment->patient->first_name . ' ' . $appointment->patient->last_name) ?? 'N/A' }}</h2>
            <p class="text-sm text-gray-500 mt-1">DNI: {{ $appointment->patient->id_number ?? 'N/A' }}</p>
        </div>
        <div class="flex space-x-3">
            <button wire:click="$set('showHistoryModal', true)" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 flex items-center transition">
                <i class="fa-solid fa-notes-medical mr-2"></i> Ver Historia
            </button>
            <button wire:click="$set('showPreviousConsultationsModal', true)" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 flex items-center transition">
                <i class="fa-solid fa-clock-rotate-left mr-2"></i> Consultas Anteriores
            </button>
        </div>
    </div>

    <!-- Main Content -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
        
        <!-- Tabs -->
        <div class="flex border-b border-gray-200">
            <button wire:click="$set('activeTab', 'consulta')" class="flex items-center px-6 py-4 text-sm font-medium {{ $activeTab == 'consulta' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                <i class="fa-solid fa-stethoscope mr-2"></i> Consulta
            </button>
            <button wire:click="$set('activeTab', 'receta')" class="flex items-center px-6 py-4 text-sm font-medium {{ $activeTab == 'receta' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                <i class="fa-solid fa-prescription-bottle-medical mr-2"></i> Receta
            </button>
        </div>

        <div class="p-6">
            @if($activeTab == 'consulta')
                <!-- Consulta Tab -->
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Diagnóstico</label>
                        <textarea wire:model="diagnostico" rows="4" class="w-full text-sm py-3 px-4 border {{ $errors->has('diagnostico') ? 'border-red-400' : 'border-blue-400' }} rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Describa el diagnóstico del paciente aquí..."></textarea>
                        @error('diagnostico') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tratamiento</label>
                        <textarea wire:model="tratamiento" rows="4" class="w-full text-sm py-3 px-4 border {{ $errors->has('tratamiento') ? 'border-red-400' : 'border-gray-200' }} rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Describa el tratamiento recomendado aquí..."></textarea>
                        @error('tratamiento') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Notas</label>
                        <textarea wire:model="notas" rows="3" class="w-full text-sm py-3 px-4 border border-gray-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Agregue notas adicionales sobre la consulta..."></textarea>
                    </div>
                </div>
            @endif

            @if($activeTab == 'receta')
                <!-- Receta Tab -->
                <div class="space-y-4">
                    <div class="grid grid-cols-12 gap-4 items-end bg-gray-50 p-4 rounded-lg font-medium text-sm text-gray-700">
                        <div class="col-span-5">Medicamento</div>
                        <div class="col-span-3">Dosis</div>
                        <div class="col-span-3">Frecuencia / Duración</div>
                        <div class="col-span-1"></div>
                    </div>

                    @foreach($medicamentos as $index => $med)
                        <div class="grid grid-cols-12 gap-4 items-center">
                            <div class="col-span-5">
                                <input type="text" wire:model="medicamentos.{{ $index }}.medicamento" placeholder="Ej: Amoxicilina 500mg" class="w-full text-sm py-2.5 px-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="col-span-3">
                                <input type="text" wire:model="medicamentos.{{ $index }}.dosis" placeholder="Ej: 1 cada 8 horas" class="w-full text-sm py-2.5 px-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="col-span-3">
                                <input type="text" wire:model="medicamentos.{{ $index }}.frecuencia" placeholder="Ej: por 7 días" class="w-full text-sm py-2.5 px-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="col-span-1 text-center">
                                <button wire:click="removeMedicamento({{ $index }})" class="text-red-500 hover:text-white hover:bg-red-500 p-2 border border-red-200 rounded-lg bg-red-50 transition">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach

                    <div class="pt-2">
                        <button wire:click="addMedicamento" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 flex items-center transition">
                            <i class="fa-solid fa-plus mr-2"></i> Añadir Medicamento
                        </button>
                    </div>
                </div>
            @endif

            <div class="mt-8 flex justify-end border-t border-gray-100 pt-6">
                <button wire:click="save" class="px-6 py-2.5 bg-blue-500 hover:bg-blue-600 text-white rounded-lg shadow-sm text-sm font-medium flex items-center transition">
                    <span wire:loading.remove wire:target="save"><i class="fa-solid fa-lock mr-2"></i> Guardar Consulta</span>
                    <span wire:loading wire:target="save"><i class="fa-solid fa-circle-notch fa-spin mr-2"></i> Guardando...</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Modals -->

    <!-- Modal Historia Médica -->
    @if($showHistoryModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-gray-900 bg-opacity-50 transition-opacity">
            <div class="relative p-4 w-full max-w-3xl max-h-full">
                <div class="relative bg-white rounded-xl shadow-lg">
                    <!-- Header -->
                    <div class="flex items-center justify-between p-5 border-b rounded-t">
                        <h3 class="text-lg font-semibold text-gray-800">
                            Historia médica del paciente
                        </h3>
                        <button wire:click="$set('showHistoryModal', false)" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center">
                            <i class="fa-solid fa-xmark text-lg"></i>
                            <span class="sr-only">Cerrar modal</span>
                        </button>
                    </div>
                    <!-- Body -->
                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Tipo de sangre:</p>
                                <p class="text-base font-semibold text-gray-900">{{ $appointment->patient->bloodType->name ?? 'No registrado' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Alergias:</p>
                                <p class="text-base font-semibold text-gray-900">{{ $appointment->patient->allergies ?: 'No registradas' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Enfermedades crónicas:</p>
                                <p class="text-base font-semibold text-gray-900">{{ $appointment->patient->chronic_conditions ?: 'No registradas' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Antecedentes quirúrgicos:</p>
                                <p class="text-base font-semibold text-gray-900">{{ $appointment->patient->surgical_history ?: 'No registradas' }}</p>
                            </div>
                        </div>
                    </div>
                    <!-- Footer -->
                    <div class="flex items-center p-5 border-t border-gray-100 rounded-b justify-end bg-gray-50">
                        <a href="{{ route('admin.patients.edit', $appointment->patient->id) }}" target="_blank" class="text-blue-600 hover:text-blue-800 font-medium text-sm transition">
                            Ver / Editar Historia Médica
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal Consultas Anteriores -->
    @if($showPreviousConsultationsModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-gray-900 bg-opacity-50 transition-opacity">
            <div class="relative p-4 w-full max-w-4xl max-h-full">
                <div class="relative bg-white rounded-xl shadow-lg flex flex-col max-h-[90vh]">
                    <!-- Header -->
                    <div class="flex items-center justify-between p-5 border-b rounded-t bg-white sticky top-0 z-10">
                        <h3 class="text-lg font-semibold text-gray-800">
                            Consultas Anteriores
                        </h3>
                        <button wire:click="$set('showPreviousConsultationsModal', false)" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center">
                            <i class="fa-solid fa-xmark text-lg"></i>
                            <span class="sr-only">Cerrar modal</span>
                        </button>
                    </div>
                    <!-- Body -->
                    <div class="p-6 overflow-y-auto bg-gray-50 flex-1 space-y-4">
                        @forelse($this->previousConsultations as $prevAppointment)
                            <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-200 transition hover:shadow-md">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <h4 class="text-base font-semibold text-gray-800 flex items-center">
                                            <i class="fa-solid fa-calendar-day text-indigo-500 mr-2"></i>
                                            {{ \Carbon\Carbon::parse($prevAppointment->date)->format('d/m/Y') }} a las {{ \Carbon\Carbon::parse($prevAppointment->start_time)->format('H:i') }}
                                        </h4>
                                        <p class="text-sm text-gray-500 mt-1 ml-6">Atendido por: Dr(a). {{ $prevAppointment->doctor->name ?? ($prevAppointment->doctor->first_name . ' ' . $prevAppointment->doctor->last_name) ?? 'N/A' }}</p>
                                    </div>
                                    <button class="px-4 py-2 text-xs font-medium text-indigo-600 border border-indigo-200 rounded-lg hover:bg-indigo-50 transition">
                                        Consultar Detalle
                                    </button>
                                </div>
                                <div class="space-y-3 mt-4 text-sm text-gray-700 bg-gray-50 p-4 rounded-lg">
                                    <p><span class="font-semibold text-gray-900">Diagnóstico:</span> {{ $prevAppointment->diagnostico }}</p>
                                    <p><span class="font-semibold text-gray-900">Tratamiento:</span> {{ $prevAppointment->tratamiento }}</p>
                                    @if($prevAppointment->notas)
                                        <p><span class="font-semibold text-gray-900">Notas:</span> {{ $prevAppointment->notas }}</p>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12">
                                <i class="fa-solid fa-folder-open text-4xl text-gray-300 mb-4"></i>
                                <p class="text-gray-500 font-medium">No se encontraron consultas anteriores para este paciente.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
</div>
