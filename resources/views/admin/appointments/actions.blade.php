<div class="flex space-x-2 justify-center">
    <!-- Botón para Iniciar Consulta -->
    <a href="{{ route('admin.appointments.consultation', $appointment->id) }}" 
       class="inline-flex items-center justify-center p-2 bg-blue-100 text-blue-600 hover:bg-blue-200 hover:text-blue-700 rounded-lg transition-colors" 
       title="Atender Consulta">
        <i class="fa-solid fa-stethoscope"></i>
    </a>
</div>
