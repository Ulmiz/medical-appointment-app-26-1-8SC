<?php

namespace App\Livewire\Admin\Appointments;

use Livewire\Component;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\User;

class CreateAppointment extends Component
{
    public $patient_id = '';
    public $doctor_id = '';
    public $date = '';
    public $start_time = '';
    public $end_time = '';
    public $reason = '';

    public function getSelectedDoctorProperty()
    {
        if (!$this->doctor_id) return null;
        if (class_exists(Doctor::class)) {
            return Doctor::find($this->doctor_id);
        }
        return null;
    }

    public function getSelectedPatientProperty()
    {
        if (!$this->patient_id) return null;
        return Patient::find($this->patient_id);
    }

    public function save()
    {
        $this->validate([
            'patient_id' => 'required',
            'doctor_id' => 'required',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'reason' => 'required|string',
        ]);

        Appointment::create([
            'patient_id' => $this->patient_id,
            'doctor_id' => $this->doctor_id,
            'date' => $this->date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'duration' => 15,
            'reason' => $this->reason,
            'status' => 1,
        ]);

        session()->flash('success', 'Cita agendada exitosamente.');
        return redirect()->route('admin.appointments.index');
    }

    public function render()
    {
        $patients = Patient::all();
        $doctors = class_exists(Doctor::class) ? Doctor::all() : collect();

        return view('livewire.admin.appointments.create-appointment', [
            'patients' => $patients,
            'doctors' => $doctors,
        ]);
    }
}
