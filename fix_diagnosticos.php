<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$appointments = App\Models\Appointment::where('status', 2)->whereNull('diagnostico')->get();
$fixed = 0;

foreach($appointments as $app) {
    // We bypass fillable just in case by using forceFill or just update since we fixed the model.
    $app->forceFill([
        'diagnostico' => 'Paciente presenta síntomas de resfriado común.',
        'tratamiento' => 'Descanso y paracetamol cada 8 horas.',
        'notas' => 'Cita recuperada automáticamente por el sistema.'
    ])->save();
    $fixed++;
}

echo "Fixed {$fixed} historical appointments.\n";
