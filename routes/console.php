<?php

use App\Console\Commands\SendDailyReports;
use App\Console\Commands\SendWhatsAppReminders;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// 📊 Reporte diario de citas a las 8:00 AM
Schedule::command(SendDailyReports::class)
    ->dailyAt('08:00')
    ->description('Reporte diario de citas al admin y doctores');

// ⏰ Recordatorios de WhatsApp a las 9:00 AM (para citas del día siguiente)
Schedule::command(SendWhatsAppReminders::class)
    ->dailyAt('09:00')
    ->description('Recordatorios WhatsApp un día antes de la cita');
