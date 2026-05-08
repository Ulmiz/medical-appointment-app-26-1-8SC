<div>
    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- MAIN FORM COLUMN (LEFT) -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- HEADER CARD -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-1">Buscar disponibilidad</h2>
                <p class="text-sm text-gray-500 mb-6">Encuentra el horario perfecto para tu cita.</p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Fecha -->
                    <div>
                        <label for="date" class="block text-xs font-medium text-gray-700 mb-1">Fecha</label>
                        <input type="date" wire:model.live="date" id="date" class="w-full text-sm py-2.5 px-3 border border-gray-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-700">
                        @error('date') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Hora Inicio -->
                    <div>
                        <label for="start_time" class="block text-xs font-medium text-gray-700 mb-1">Hora Inicio</label>
                        <input type="time" wire:model.live="start_time" id="start_time" class="w-full text-sm py-2.5 px-3 border border-gray-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-700">
                        @error('start_time') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Hora Fin -->
                    <div>
                        <label for="end_time" class="block text-xs font-medium text-gray-700 mb-1">Hora Fin</label>
                        <input type="time" wire:model.live="end_time" id="end_time" class="w-full text-sm py-2.5 px-3 border border-gray-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-700">
                        @error('end_time') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- DOCTOR SELECTION CARD -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Seleccionar Médico</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse($doctors as $doc)
                        <label class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none border-gray-200 {{ $doctor_id == $doc->id ? 'ring-2 ring-indigo-500 border-indigo-500' : 'hover:border-indigo-200 hover:bg-gray-50' }}">
                            <input type="radio" wire:model.live="doctor_id" value="{{ $doc->id }}" class="sr-only">
                            <span class="flex flex-1">
                                <span class="flex flex-col">
                                    <span class="block text-sm font-medium text-gray-900">{{ $doc->name ?? ($doc->first_name . ' ' . $doc->last_name) }}</span>
                                    <span class="mt-1 flex items-center text-xs text-gray-500">Médico General / Especialista</span>
                                </span>
                            </span>
                            @if($doctor_id == $doc->id)
                                <svg class="h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                </svg>
                            @endif
                        </label>
                    @empty
                        <div class="col-span-full py-4 text-center text-sm text-gray-500">
                            No hay doctores registrados en el sistema.
                        </div>
                    @endforelse
                </div>
                @error('doctor_id') <span class="text-xs text-red-500 mt-2 block">{{ $message }}</span> @enderror
            </div>
            
            <!-- PATIENT & REASON SECTION -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Paciente y Motivo</h3>
                
                <div class="mb-5">
                    <label for="patient_id" class="block text-sm font-medium text-gray-700 mb-1">Seleccionar Paciente</label>
                    <select wire:model.live="patient_id" id="patient_id" class="w-full text-sm py-2.5 px-3 border border-gray-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-700">
                        <option value="">Seleccione un paciente de la lista</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}">{{ $patient->name ?? ($patient->first_name . ' ' . $patient->last_name) }}</option>
                        @endforeach
                    </select>
                    @error('patient_id') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="reason" class="block text-sm font-medium text-gray-700 mb-1">Motivo de la cita <span class="text-red-500">*</span></label>
                    <textarea wire:model.live="reason" id="reason" rows="3" class="w-full text-sm py-2.5 px-3 border border-gray-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-700" placeholder="Ej. Chequeo de medicamentos..."></textarea>
                    @error('reason') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

        </div>

        <!-- SUMMARY SIDEBAR (RIGHT) -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-6">
                <h3 class="text-lg font-bold text-gray-800 mb-6">Resumen de la cita</h3>

                <div class="space-y-4 mb-8">
                    <div class="flex justify-between border-b border-gray-100 pb-3">
                        <span class="text-sm text-gray-500">Doctor:</span>
                        <span class="text-sm font-medium text-gray-800 text-right">{{ $this->selectedDoctor ? ($this->selectedDoctor->name ?? $this->selectedDoctor->first_name . ' ' . $this->selectedDoctor->last_name) : 'No seleccionado' }}</span>
                    </div>
                    
                    <div class="flex justify-between border-b border-gray-100 pb-3">
                        <span class="text-sm text-gray-500">Fecha:</span>
                        <span class="text-sm font-medium text-gray-800">{{ $date ? \Carbon\Carbon::parse($date)->format('Y-m-d') : 'No seleccionada' }}</span>
                    </div>
                    
                    <div class="flex justify-between border-b border-gray-100 pb-3">
                        <span class="text-sm text-gray-500">Horario:</span>
                        <span class="text-sm font-medium text-gray-800">
                            @if($start_time && $end_time)
                                {{ $start_time }} - {{ $end_time }}
                            @else
                                No seleccionado
                            @endif
                        </span>
                    </div>

                    <div class="flex justify-between border-b border-gray-100 pb-3">
                        <span class="text-sm text-gray-500">Paciente:</span>
                        <span class="text-sm font-medium text-gray-800 text-right">{{ $this->selectedPatient ? ($this->selectedPatient->name ?? $this->selectedPatient->first_name . ' ' . $this->selectedPatient->last_name) : 'No seleccionado' }}</span>
                    </div>
                </div>

                <button wire:click="save" wire:loading.attr="disabled" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-3 px-4 rounded-lg shadow-sm transition duration-150 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 flex justify-center items-center disabled:opacity-50 disabled:cursor-not-allowed">
                    <span wire:loading.remove wire:target="save">Confirmar cita</span>
                    <span wire:loading wire:target="save">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Guardando...
                    </span>
                </button>
            </div>
        </div>

    </div>
</div>
