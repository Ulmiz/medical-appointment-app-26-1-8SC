<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte Diario – Healthify</title>
</head>
<body style="margin:0;padding:0;background:#f3f4f6;font-family:Arial,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f3f4f6;padding:30px 0;">
    <tr>
        <td align="center">
            <table width="640" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,0.08);">

                <!-- Header -->
                <tr>
                    <td style="background:linear-gradient(135deg,#059669,#0d9488);padding:28px 40px;">
                        <table width="100%">
                            <tr>
                                <td>
                                    <div style="color:#fff;font-size:22px;font-weight:bold;">Health<span style="color:#a7f3d0;">ify</span></div>
                                    <div style="color:#d1fae5;font-size:12px;margin-top:2px;">Sistema de Gestión Médica</div>
                                </td>
                                <td align="right">
                                    <div style="color:#fff;font-size:13px;">📋 Reporte Diario</div>
                                    <div style="color:#d1fae5;font-size:12px;">{{ now()->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }}</div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <!-- Title -->
                <tr>
                    <td style="padding:24px 40px 0;text-align:center;">
                        <h1 style="color:#059669;font-size:18px;margin:0;">
                            @if($isAdmin)
                                📊 Resumen General – Citas del Día
                            @else
                                👨‍⚕️ Tus Pacientes de Hoy
                            @endif
                        </h1>
                        <p style="color:#6b7280;font-size:13px;margin-top:6px;">
                            @if($isAdmin)
                                {{ $appointments->count() }} cita(s) programadas para hoy en todos los consultorios.
                            @else
                                Tienes {{ $appointments->count() }} paciente(s) programado(s) para hoy.
                            @endif
                        </p>
                    </td>
                </tr>

                <!-- Table -->
                <tr>
                    <td style="padding:20px 40px;">
                        @if($appointments->count() > 0)
                        <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
                            <thead>
                                <tr style="background:#f0fdf4;">
                                    <th style="padding:10px 12px;text-align:left;font-size:11px;text-transform:uppercase;letter-spacing:1px;color:#059669;border-bottom:2px solid #d1fae5;">Paciente</th>
                                    @if($isAdmin)
                                    <th style="padding:10px 12px;text-align:left;font-size:11px;text-transform:uppercase;letter-spacing:1px;color:#059669;border-bottom:2px solid #d1fae5;">Doctor</th>
                                    @endif
                                    <th style="padding:10px 12px;text-align:left;font-size:11px;text-transform:uppercase;letter-spacing:1px;color:#059669;border-bottom:2px solid #d1fae5;">Hora</th>
                                    <th style="padding:10px 12px;text-align:left;font-size:11px;text-transform:uppercase;letter-spacing:1px;color:#059669;border-bottom:2px solid #d1fae5;">Motivo</th>
                                    <th style="padding:10px 12px;text-align:left;font-size:11px;text-transform:uppercase;letter-spacing:1px;color:#059669;border-bottom:2px solid #d1fae5;">Estatus</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($appointments as $i => $appt)
                                <tr style="background:{{ $i % 2 === 0 ? '#ffffff' : '#f9fafb' }};">
                                    <td style="padding:12px;font-size:13px;color:#111827;border-bottom:1px solid #f3f4f6;">
                                        {{ $appt->patient->name ?? 'N/A' }}
                                    </td>
                                    @if($isAdmin)
                                    <td style="padding:12px;font-size:13px;color:#374151;border-bottom:1px solid #f3f4f6;">
                                        Dr. {{ $appt->doctor->name ?? 'N/A' }}
                                    </td>
                                    @endif
                                    <td style="padding:12px;font-size:13px;color:#374151;border-bottom:1px solid #f3f4f6;">
                                        {{ substr($appt->start_time, 0, 5) }}
                                    </td>
                                    <td style="padding:12px;font-size:12px;color:#6b7280;border-bottom:1px solid #f3f4f6;">
                                        {{ \Illuminate\Support\Str::limit($appt->reason ?? '—', 40) }}
                                    </td>
                                    <td style="padding:12px;border-bottom:1px solid #f3f4f6;">
                                        @php $status = $appt->status ?? 1; @endphp
                                        <span style="background:{{ $status == 1 ? '#dbeafe' : ($status == 2 ? '#dcfce7' : '#fee2e2') }};color:{{ $status == 1 ? '#1d4ed8' : ($status == 2 ? '#166534' : '#991b1b') }};padding:3px 10px;border-radius:12px;font-size:11px;font-weight:bold;">
                                            {{ $status == 1 ? 'Programada' : ($status == 2 ? 'Finalizada' : 'Cancelada') }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <div style="text-align:center;padding:30px;color:#9ca3af;font-size:14px;">
                            🎉 No hay citas programadas para hoy.
                        </div>
                        @endif
                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td style="background:#f0fdf4;border-top:2px solid #d1fae5;padding:14px 40px;text-align:center;">
                        <p style="font-size:11px;color:#9ca3af;margin:0;">
                            <strong style="color:#059669;">Healthify</strong> – Reporte generado automáticamente a las 8:00 AM
                        </p>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>
</body>
</html>
