<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class AppointmentConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Appointment $appointment) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '✅ Confirmación de Cita – Healthify #' . str_pad($this->appointment->id, 6, '0', STR_PAD_LEFT),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.appointment-confirmation',
            with: ['appointment' => $this->appointment],
        );
    }

    public function attachments(): array
    {
        $pdf = Pdf::loadView('pdf.appointment-confirmation', [
            'appointment' => $this->appointment,
        ]);

        $filename = 'cita-' . str_pad($this->appointment->id, 6, '0', STR_PAD_LEFT) . '.pdf';

        return [
            Attachment::fromData(fn () => $pdf->output(), $filename)
                ->withMime('application/pdf'),
        ];
    }
}
