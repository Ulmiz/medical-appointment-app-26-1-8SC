<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprobante de Cita – Healthify</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 13px; color: #1a1a2e; background: #fff; }

        .header {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: white;
            padding: 30px 40px;
            display: table;
            width: 100%;
        }
        .header-left { display: table-cell; vertical-align: middle; }
        .header-right { display: table-cell; vertical-align: middle; text-align: right; }
        .logo { font-size: 26px; font-weight: bold; letter-spacing: -0.5px; }
        .logo span { color: #a5b4fc; }
        .tagline { font-size: 11px; color: #c7d2fe; margin-top: 2px; }
        .badge {
            display: inline-block;
            background: rgba(255,255,255,0.2);
            border: 1px solid rgba(255,255,255,0.3);
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 11px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .body { padding: 30px 40px; }

        .title-section { text-align: center; margin-bottom: 28px; }
        .title-section h1 { font-size: 20px; color: #4f46e5; font-weight: bold; }
        .title-section p { color: #6b7280; font-size: 12px; margin-top: 4px; }

        .divider { border: none; border-top: 2px solid #e0e7ff; margin: 20px 0; }

        .info-grid { display: table; width: 100%; margin-bottom: 20px; }
        .info-col { display: table-cell; width: 50%; vertical-align: top; padding-right: 15px; }
        .info-col:last-child { padding-right: 0; padding-left: 15px; }

        .info-box {
            background: #f8faff;
            border: 1px solid #e0e7ff;
            border-radius: 8px;
            padding: 16px;
        }
        .info-box h3 {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: #6366f1;
            font-weight: bold;
            margin-bottom: 12px;
            padding-bottom: 6px;
            border-bottom: 1px solid #e0e7ff;
        }
        .info-row { display: table; width: 100%; margin-bottom: 8px; }
        .info-label { display: table-cell; color: #6b7280; font-size: 11px; width: 40%; }
        .info-value { display: table-cell; color: #111827; font-size: 12px; font-weight: 600; }

        .appointment-box {
            background: linear-gradient(135deg, #eef2ff 0%, #f5f3ff 100%);
            border: 2px solid #c7d2fe;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            text-align: center;
        }
        .appointment-box h3 { font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #6366f1; margin-bottom: 10px; }
        .appointment-date { font-size: 22px; font-weight: bold; color: #4f46e5; }
        .appointment-time { font-size: 16px; color: #7c3aed; margin-top: 4px; }

        .reason-box {
            background: #f9fafb;
            border-left: 4px solid #4f46e5;
            padding: 14px 16px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .reason-box h3 { font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #4f46e5; margin-bottom: 6px; }
        .reason-box p { color: #374151; line-height: 1.5; }

        .status-badge {
            display: inline-block;
            background: #dcfce7;
            color: #166534;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: bold;
            border: 1px solid #86efac;
        }

        .footer {
            background: #f8faff;
            border-top: 2px solid #e0e7ff;
            padding: 16px 40px;
            text-align: center;
            font-size: 10px;
            color: #9ca3af;
        }
        .footer strong { color: #4f46e5; }
    </style>
</head>
<body>

<div class="header">
    <div class="header-left">
        <div class="logo">Health<span>ify</span></div>
        <div class="tagline">Sistema de Gestión Médica</div>
    </div>
    <div class="header-right">
        <div class="badge">✓ Cita Confirmada</div>
    </div>
</div>

<div class="body">

    <div class="title-section">
        <h1>Comprobante de Cita Médica</h1>
        <p>Este documento es tu comprobante oficial de cita. Consérvalo para el día de tu consulta.</p>
    </div>

    <div class="appointment-box">
        <h3>📅 Fecha y Hora de la Cita</h3>
        <div class="appointment-date">{{ \Carbon\Carbon::parse($appointment->date)->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}</div>
        <div class="appointment-time">🕐 {{ substr($appointment->start_time, 0, 5) }} – {{ substr($appointment->end_time, 0, 5) }} hrs</div>
        <br>
        <span class="status-badge">Programada</span>
    </div>

    <div class="info-grid">
        <div class="info-col">
            <div class="info-box">
                <h3>👤 Datos del Paciente</h3>
                <div class="info-row">
                    <div class="info-label">Nombre:</div>
                    <div class="info-value">{{ $appointment->patient->name ?? 'N/A' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Email:</div>
                    <div class="info-value">{{ $appointment->patient->email ?? 'N/A' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Teléfono:</div>
                    <div class="info-value">{{ $appointment->patient->phone ?? 'N/A' }}</div>
                </div>
            </div>
        </div>
        <div class="info-col">
            <div class="info-box">
                <h3>🩺 Datos del Doctor</h3>
                <div class="info-row">
                    <div class="info-label">Doctor:</div>
                    <div class="info-value">Dr. {{ $appointment->doctor->name ?? 'N/A' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Email:</div>
                    <div class="info-value">{{ $appointment->doctor->email ?? 'N/A' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Especialidad:</div>
                    <div class="info-value">{{ $appointment->doctor->specialty ?? 'General' }}</div>
                </div>
            </div>
        </div>
    </div>

    @if($appointment->reason)
    <div class="reason-box">
        <h3>📋 Motivo de la Consulta</h3>
        <p>{{ $appointment->reason }}</p>
    </div>
    @endif

    <hr class="divider">

    <div style="text-align:center; font-size: 11px; color: #6b7280;">
        <p>Por favor, preséntate <strong>15 minutos antes</strong> de tu cita.</p>
        <p style="margin-top:4px;">Folio de cita: <strong>#{{ str_pad($appointment->id, 6, '0', STR_PAD_LEFT) }}</strong></p>
    </div>

</div>

<div class="footer">
    <strong>Healthify</strong> – Sistema de Gestión Médica &nbsp;|&nbsp;
    Este es un correo automático, por favor no responder &nbsp;|&nbsp;
    Generado el {{ now()->locale('es')->isoFormat('D [de] MMMM [de] YYYY, HH:mm') }}
</div>

</body>
</html>
