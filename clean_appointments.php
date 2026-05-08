<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$appointments = App\Models\Appointment::all();
$seen = [];
$deleted = 0;

foreach($appointments as $app) {
    // Generate a unique hash for the appointment based on patient, doctor, date and start_time
    $hash = $app->patient_id . '-' . $app->doctor_id . '-' . $app->date . '-' . $app->start_time;
    
    if (in_array($hash, $seen)) {
        $app->delete();
        $deleted++;
    } else {
        $seen[] = $hash;
    }
}

echo "Deleted {$deleted} duplicate appointments.\n";
