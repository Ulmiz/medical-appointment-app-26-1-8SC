<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use App\Services\WhatsAppService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendWhatsAppReminders extends Command
{
    protected $signature   = 'app:send-whatsapp-reminders';
    protected $description = 'Envía recordatorios de WhatsApp a los pacientes con cita al día siguiente.';

    public function handle(WhatsAppService $whatsapp): int
    {
        $tomorrow = now()->addDay()->toDateString();

        $appointments = Appointment::with(['patient', 'doctor'])
            ->where('date', $tomorrow)
            ->where('status', 1) // Solo programadas
            ->get();

        if ($appointments->isEmpty()) {
            $this->info("No hay citas programadas para mañana ({$tomorrow}).");
            Log::info("[WhatsApp Reminders] No hay citas para mañana ({$tomorrow}).");
            return self::SUCCESS;
        }

        $this->info("Enviando {$appointments->count()} recordatorio(s) para {$tomorrow}...");

        $sent = 0;
        foreach ($appointments as $appointment) {
            try {
                $whatsapp->sendReminder($appointment);
                $this->line("  ✓ Recordatorio enviado a: " . ($appointment->patient->name ?? 'N/A'));
                $sent++;
            } catch (\Exception $e) {
                $this->error("  ✗ Error con cita #{$appointment->id}: " . $e->getMessage());
                Log::error("[WhatsApp Reminders] Error con cita #{$appointment->id}: " . $e->getMessage());
            }
        }

        $this->info("Proceso completado. {$sent}/{$appointments->count()} recordatorios enviados.");
        Log::info("[WhatsApp Reminders] {$sent}/{$appointments->count()} recordatorios enviados para {$tomorrow}.");

        return self::SUCCESS;
    }
}
