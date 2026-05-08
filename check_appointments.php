<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$appointments = App\Models\Appointment::with('patient')->get();
foreach($appointments as $app) {
    echo "ID: {$app->id}, Patient: {$app->patient_id}, Status: {$app->status}, Diagnostico: {$app->diagnostico}\n";
}
