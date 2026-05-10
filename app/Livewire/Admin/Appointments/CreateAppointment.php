<?php

namespace App\Livewire\Admin\Appointments;

use Livewire\Component;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use App\Mail\AppointmentConfirmation;
use App\Services\WhatsAppService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class CreateAppointment extends Component
{
    public $patient_id = '';
    public $doctor_id = '';
    public $date = '';
    public $start_time = '';
    public $end_time = '';
    public $reason = '';

    // Guard para evitar doble envío
    public $saving = false;

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
        if ($this->saving) return;
        $this->saving = true;

        $this->validate([
            'patient_id' => 'required',
            'doctor_id'  => 'required',
            'date'       => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time'   => 'required|date_format:H:i|after:start_time',
            'reason'     => 'required|string',
        ]);

        $appointment = Appointment::create([
            'patient_id' => $this->patient_id,
            'doctor_id'  => $this->doctor_id,
            'date'       => $this->date,
            'start_time' => $this->start_time,
            'end_time'   => $this->end_time,
            'duration'   => 15,
            'reason'     => $this->reason,
            'status'     => 1,
        ]);

        // Cargar relaciones necesarias para correos y WhatsApp
        $appointment->load(['patient.user', 'doctor.user']);

        // 1️⃣ Correo al paciente (con PDF adjunto)
        try {
            $patientEmail = $appointment->patient->email ?? null;
            if ($patientEmail && filter_var($patientEmail, FILTER_VALIDATE_EMAIL)) {
                Mail::to($patientEmail)->send(new AppointmentConfirmation($appointment));
                Log::info("[Cita #{$appointment->id}] Correo enviado al paciente: {$patientEmail}");
            }
        } catch (\Exception $e) {
            Log::error("[Cita #{$appointment->id}] Error al enviar correo al paciente: " . $e->getMessage());
        }

        // 2️⃣ Correo al doctor (con PDF adjunto)
        try {
            $doctorEmail = $appointment->doctor->email ?? null;
            if ($doctorEmail && filter_var($doctorEmail, FILTER_VALIDATE_EMAIL)) {
                Mail::to($doctorEmail)->send(new AppointmentConfirmation($appointment));
                Log::info("[Cita #{$appointment->id}] Correo enviado al doctor: {$doctorEmail}");
            }
        } catch (\Exception $e) {
            Log::error("[Cita #{$appointment->id}] Error al enviar correo al doctor: " . $e->getMessage());
        }

        // 3️⃣ WhatsApp de confirmación al paciente
        try {
            $whatsapp = new WhatsAppService();
            $whatsapp->sendConfirmation($appointment);
        } catch (\Exception $e) {
            Log::error("[Cita #{$appointment->id}] Error al enviar WhatsApp: " . $e->getMessage());
        }

        session()->flash('success', 'Cita agendada exitosamente. Se enviaron notificaciones al paciente y al doctor.');
        return redirect()->route('admin.appointments.index');
    }

    public function render()
    {
        $patients = Patient::with('user')->get();
        $doctors  = class_exists(Doctor::class) ? Doctor::with('user')->get() : collect();

        return view('livewire.admin.appointments.create-appointment', [
            'patients' => $patients,
            'doctors'  => $doctors,
        ]);
    }
}
