<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Appointment;

class ConsultationManager extends Component
{
    public Appointment $appointment;
    public $activeTab = 'consulta';
    
    // Consulta Tab
    public $diagnostico = '';
    public $tratamiento = '';
    public $notas = '';

    // Receta Tab
    public $medicamentos = [];

    // Modals
    public $showHistoryModal = false;
    public $showPreviousConsultationsModal = false;

    public function mount(Appointment $appointment)
    {
        $this->appointment = $appointment;
        $this->medicamentos = [
            ['medicamento' => '', 'dosis' => '', 'frecuencia' => '']
        ];
        
        // Cargar datos si ya existen en la base de datos
        if ($appointment->diagnostico) $this->diagnostico = $appointment->diagnostico;
        if ($appointment->tratamiento) $this->tratamiento = $appointment->tratamiento;
        if ($appointment->notas) $this->notas = $appointment->notas;
        if ($appointment->medicamentos) {
            $this->medicamentos = is_array($appointment->medicamentos) ? $appointment->medicamentos : json_decode($appointment->medicamentos, true);
        }
    }

    public function addMedicamento()
    {
        $this->medicamentos[] = ['medicamento' => '', 'dosis' => '', 'frecuencia' => ''];
    }

    public function removeMedicamento($index)
    {
        unset($this->medicamentos[$index]);
        $this->medicamentos = array_values($this->medicamentos);
    }

    public function save()
    {
        $this->validate([
            'diagnostico' => 'required|string',
            'tratamiento' => 'required|string',
            'notas'       => 'nullable|string',
        ]);

        $this->appointment->update([
            'diagnostico' => $this->diagnostico,
            'tratamiento' => $this->tratamiento,
            'notas' => $this->notas,
            'medicamentos' => $this->medicamentos,
            'status' => 2 // 2 representa cita finalizada o atendida
        ]);

        session()->flash('success', 'Consulta guardada y finalizada exitosamente.');
        return redirect()->route('admin.appointments.index');
    }

    public function getPreviousConsultationsProperty()
    {
        return $this->appointment->patient->appointments()
            ->where('id', '!=', $this->appointment->id)
// ->whereNotNull('diagnostico')
            ->orderBy('date', 'desc')
            ->get();
    }

    public function render()
    {
        return view('livewire.admin.consultation-manager');
    }
}
