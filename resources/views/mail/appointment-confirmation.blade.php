<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Confirmación de Cita – Healthify</title>
</head>
<body style="margin:0;padding:0;background:#f3f4f6;font-family:Arial,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f3f4f6;padding:30px 0;">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,0.08);">

                <!-- Header -->
                <tr>
                    <td style="background:linear-gradient(135deg,#4f46e5,#7c3aed);padding:32px 40px;">
                        <table width="100%">
                            <tr>
                                <td>
                                    <div style="color:#fff;font-size:26px;font-weight:bold;">Health<span style="color:#a5b4fc;">ify</span></div>
                                    <div style="color:#c7d2fe;font-size:12px;margin-top:2px;">Sistema de Gestión Médica</div>
                                </td>
                                <td align="right">
                                    <span style="background:rgba(255,255,255,0.2);border:1px solid rgba(255,255,255,0.3);color:#fff;padding:6px 14px;border-radius:20px;font-size:11px;letter-spacing:1px;">✓ CONFIRMADA</span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <!-- Title -->
                <tr>
                    <td style="padding:28px 40px 0;text-align:center;">
                        <h1 style="color:#4f46e5;font-size:20px;margin:0;">Cita Médica Confirmada</h1>
                        <p style="color:#6b7280;font-size:13px;margin-top:6px;">Tu cita ha sido agendada exitosamente en el sistema Healthify.</p>
                    </td>
                </tr>

                <!-- Date Box -->
                <tr>
                    <td style="padding:20px 40px;">
                        <table width="100%" style="background:linear-gradient(135deg,#eef2ff,#f5f3ff);border:2px solid #c7d2fe;border-radius:10px;padding:20px;" cellpadding="0" cellspacing="0">
                            <tr>
                                <td align="center">
                                    <div style="font-size:11px;text-transform:uppercase;letter-spacing:1px;color:#6366f1;margin-bottom:8px;">📅 Fecha y Hora</div>
                                    <div style="font-size:22px;font-weight:bold;color:#4f46e5;">
                                        {{ \Carbon\Carbon::parse($appointment->date)->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
                                    </div>
                                    <div style="font-size:16px;color:#7c3aed;margin-top:6px;">
                                        🕐 {{ substr($appointment->start_time, 0, 5) }} – {{ substr($appointment->end_time, 0, 5) }} hrs
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <!-- Patient & Doctor -->
                <tr>
                    <td style="padding:0 40px 20px;">
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="48%" style="background:#f8faff;border:1px solid #e0e7ff;border-radius:8px;padding:16px;vertical-align:top;">
                                    <div style="font-size:10px;text-transform:uppercase;letter-spacing:1px;color:#6366f1;font-weight:bold;margin-bottom:10px;padding-bottom:6px;border-bottom:1px solid #e0e7ff;">👤 Paciente</div>
                                    <div style="font-size:13px;font-weight:bold;color:#111827;margin-bottom:4px;">{{ $appointment->patient->name ?? 'N/A' }}</div>
                                    <div style="font-size:12px;color:#6b7280;">{{ $appointment->patient->email ?? '' }}</div>
                                    <div style="font-size:12px;color:#6b7280;">{{ $appointment->patient->phone ?? '' }}</div>
                                </td>
                                <td width="4%"></td>
                                <td width="48%" style="background:#f8faff;border:1px solid #e0e7ff;border-radius:8px;padding:16px;vertical-align:top;">
                                    <div style="font-size:10px;text-transform:uppercase;letter-spacing:1px;color:#6366f1;font-weight:bold;margin-bottom:10px;padding-bottom:6px;border-bottom:1px solid #e0e7ff;">🩺 Doctor</div>
                                    <div style="font-size:13px;font-weight:bold;color:#111827;margin-bottom:4px;">Dr. {{ $appointment->doctor->name ?? 'N/A' }}</div>
                                    <div style="font-size:12px;color:#6b7280;">{{ $appointment->doctor->specialty ?? 'General' }}</div>
                                    <div style="font-size:12px;color:#6b7280;">{{ $appointment->doctor->email ?? '' }}</div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                @if($appointment->reason)
                <!-- Reason -->
                <tr>
                    <td style="padding:0 40px 20px;">
                        <div style="background:#f9fafb;border-left:4px solid #4f46e5;padding:14px 16px;border-radius:4px;">
                            <div style="font-size:10px;text-transform:uppercase;letter-spacing:1px;color:#4f46e5;font-weight:bold;margin-bottom:6px;">📋 Motivo de Consulta</div>
                            <p style="color:#374151;font-size:13px;line-height:1.5;margin:0;">{{ $appointment->reason }}</p>
                        </div>
                    </td>
                </tr>
                @endif

                <!-- Notice -->
                <tr>
                    <td style="padding:0 40px 28px;text-align:center;">
                        <div style="background:#fef3c7;border:1px solid #fcd34d;border-radius:8px;padding:12px;font-size:12px;color:#92400e;">
                            ⚠️ Por favor preséntate <strong>15 minutos antes</strong> de tu cita con una identificación oficial.
                        </div>
                        <div style="margin-top:10px;font-size:11px;color:#9ca3af;">
                            Folio: <strong style="color:#4f46e5;">#{{ str_pad($appointment->id, 6, '0', STR_PAD_LEFT) }}</strong>
                        </div>
                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td style="background:#f8faff;border-top:2px solid #e0e7ff;padding:16px 40px;text-align:center;">
                        <p style="font-size:11px;color:#9ca3af;margin:0;">
                            <strong style="color:#4f46e5;">Healthify</strong> – Sistema de Gestión Médica
                            &nbsp;|&nbsp; Este es un correo automático, favor no responder
                        </p>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>
</body>
</html>
