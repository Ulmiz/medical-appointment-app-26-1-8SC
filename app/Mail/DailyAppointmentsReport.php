<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class DailyAppointmentsReport extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Collection $appointments,
        public bool $isAdmin = true,
        public ?string $doctorName = null,
    ) {}

    public function envelope(): Envelope
    {
        $subject = $this->isAdmin
            ? '📊 Reporte Diario de Citas – Healthify ' . now()->format('d/m/Y')
            : '👨‍⚕️ Tus Pacientes de Hoy – Healthify ' . now()->format('d/m/Y');

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.daily-report',
            with: [
                'appointments' => $this->appointments,
                'isAdmin'      => $this->isAdmin,
                'doctorName'   => $this->doctorName,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
