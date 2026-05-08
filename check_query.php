<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$appointment = App\Models\Appointment::find(1);
$prev = $appointment->patient->appointments()
            ->where('id', '!=', $appointment->id)
            ->whereNotNull('diagnostico')
            ->orderBy('date', 'desc')
            ->get();
            
echo "Found " . $prev->count() . " prev appointments.\n";
foreach($prev as $p) {
    echo "ID: {$p->id}, Diagnostico: {$p->diagnostico}\n";
}
