<?php

namespace App\Console\Commands;

use App\Mail\DailyAppointmentsReport;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendDailyReports extends Command
{
    protected $signature   = 'app:send-daily-reports';
    protected $description = 'Envía el reporte diario de citas al administrador y a cada doctor.';

    public function handle(): int
    {
        $today = now()->toDateString();

        $this->info("Generando reportes para el {$today}...");

        // 1. Obtener TODAS las citas del día
        $allAppointments = Appointment::with(['patient', 'doctor'])
            ->where('date', $today)
            ->orderBy('start_time')
            ->get();

        // 2. Enviar reporte al Admin (Tu Gmail)
        $toAdmin = 'principito.pro@gmail.com';

        try {
            Mail::to($toAdmin)->send(new DailyAppointmentsReport($allAppointments, isAdmin: true));
            $this->line("  ✓ Reporte enviado al administrador: {$toAdmin}");
        } catch (\Exception $e) {
            $this->error("  ✗ Error Admin: " . $e->getMessage());
        }

        // 3. Enviar reportes a Doctores y Pacientes
        foreach ($allAppointments as $appt) {
            // A cada Doctor
            if ($appt->doctor && $appt->doctor->email) {
                try {
                    Mail::to($appt->doctor->email)->send(
                        new DailyAppointmentsReport(collect([$appt]), isAdmin: false, doctorName: $appt->doctor->name)
                    );
                    $this->line("  ✓ Reporte enviado al Doctor: {$appt->doctor->email}");
                } catch (\Exception $e) {
                    $this->error("  ✗ Error Doctor: " . $e->getMessage());
                }
            }

            // A cada Paciente (incluyendo e22080753@itmerida.edu.mx)
            if ($appt->patient && $appt->patient->email) {
                try {
                    Mail::to($appt->patient->email)->send(
                        new \App\Mail\AppointmentConfirmation($appt)
                    );
                    $this->line("  ✓ Correo con PDF enviado al PACIENTE: {$appt->patient->email}");
                } catch (\Exception $e) {
                    $this->error("  ✗ Error Paciente: " . $e->getMessage());
                }
            }
        }

        $this->info('Proceso de reportes completado.');
        return self::SUCCESS;
    }
}
