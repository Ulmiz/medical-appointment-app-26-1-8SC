<?php

namespace App\Services;

use App\Models\Appointment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected string $sid;
    protected string $token;
    protected string $from;

    public function __construct()
    {
        $this->sid   = config('services.twilio.sid', '');
        $this->token = config('services.twilio.token', '');
        $this->from  = config('services.twilio.whatsapp_from', 'whatsapp:+14155238886');
    }

    /**
     * Envía mensaje de confirmación inmediata al agendar una cita.
     */
    public function sendConfirmation(Appointment $appointment): void
    {
        $patientName = $appointment->patient->name ?? 'Paciente';
        $doctorName  = $appointment->doctor->name  ?? 'Doctor';
        $specialty   = $appointment->doctor->specialty ?? 'General';
        $date        = \Carbon\Carbon::parse($appointment->date)->locale('es')->isoFormat('dddd D [de] MMMM [de] YYYY');
        $time        = substr($appointment->start_time, 0, 5) . ' - ' . substr($appointment->end_time, 0, 5);
        $reason      = $appointment->reason ?? 'Consulta general';

        $message = "🏥 *COMPROBANTE DE CITA – Healthify*\n\n"
            . "Hola *{$patientName}*, se ha generado tu comprobante de cita médica.\n\n"
            . "👤 *Paciente:* {$patientName}\n"
            . "🩺 *Doctor:* Dr. {$doctorName} ({$specialty})\n"
            . "📅 *Fecha:* {$date}\n"
            . "🕐 *Hora:* {$time} hrs\n"
            . "📋 *Motivo:* {$reason}\n\n"
            . "📌 *Folio de Cita:* #" . str_pad($appointment->id, 6, '0', STR_PAD_LEFT) . "\n\n"
            . "_Nota: El comprobante oficial en PDF ha sido enviado a tu correo electrónico._\n"
            . "Por favor, preséntate 15 minutos antes.";

        $phone = $appointment->patient->phone ?? null;
        $this->send($phone, $message, 'CONFIRMACIÓN');
    }

    /**
     * Envía recordatorio automático un día antes de la cita.
     */
    public function sendReminder(Appointment $appointment): void
    {
        $patientName = $appointment->patient->name ?? 'Paciente';
        $doctorName  = $appointment->doctor->name  ?? 'Doctor';
        $date        = \Carbon\Carbon::parse($appointment->date)->locale('es')->isoFormat('dddd D [de] MMMM [de] YYYY');
        $time        = substr($appointment->start_time, 0, 5);

        $message = "⏰ *Healthify – Recordatorio de Cita*\n\n"
            . "Hola *{$patientName}*, te recordamos que mañana tienes una cita médica.\n\n"
            . "🩺 *Doctor:* Dr. {$doctorName}\n"
            . "📅 *Fecha:* {$date}\n"
            . "🕐 *Hora:* {$time} hrs\n\n"
            . "_Si necesitas cancelar o reagendar, contacta al hospital con anticipación._";

        $phone = $appointment->patient->phone ?? null;
        $this->send($phone, $message, 'RECORDATORIO');
    }

    /**
     * Realiza la llamada HTTP a la API de Twilio.
     */
    protected function send(?string $phone, string $message, string $type = 'MSG'): void
    {
        // Validar que existan credenciales y número de teléfono
        if (!$this->sid || !$this->token) {
            Log::info("[WhatsApp {$type}] Credenciales de Twilio no configuradas. Mensaje simulado:", [
                'phone'   => $phone ?? 'N/A',
                'message' => $message,
            ]);
            return;
        }

        if (!$phone) {
            Log::warning("[WhatsApp {$type}] No hay número de teléfono registrado para este paciente.");
            return;
        }

        // --- FORMATEO AUTOMÁTICO ---
        $cleanPhone = preg_replace('/[^0-9]/', '', $phone);

        // Si tiene 10 dígitos (ej: 9991131548), ponerle +521
        if (strlen($cleanPhone) === 10) {
            $to = "whatsapp:+521" . $cleanPhone;
        } 
        // Si ya tiene el 52 pero le falta el +, ponérselo
        elseif (strlen($cleanPhone) === 12 && str_starts_with($cleanPhone, '52')) {
            $to = "whatsapp:+" . $cleanPhone;
        }
        // Si ya viene con el formato completo o es internacional
        else {
            $to = str_starts_with($phone, 'whatsapp:') ? $phone : "whatsapp:" . $phone;
            // Asegurar que tenga el signo + si no es 'whatsapp:' literal
            if (str_starts_with($to, 'whatsapp:') && !str_contains($to, '+')) {
                $to = str_replace('whatsapp:', 'whatsapp:+', $to);
            }
        }

        try {
            $url = "https://api.twilio.com/2010-04-01/Accounts/{$this->sid}/Messages.json";

            $response = Http::withBasicAuth($this->sid, $this->token)
                ->asForm()
                ->post($url, [
                    'From' => $this->from,
                    'To'   => $to,
                    'Body' => $message,
                ]);

            if ($response->successful()) {
                Log::info("[WhatsApp {$type}] Mensaje enviado correctamente a {$to}. SID: " . $response->json('sid'));
            } else {
                Log::error("[WhatsApp {$type}] Error al enviar mensaje. Status: " . $response->status() . ' - ' . $response->body());
            }
        } catch (\Exception $e) {
            Log::error("[WhatsApp {$type}] Excepción: " . $e->getMessage());
        }
    }
}
