<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$patients = App\Models\Patient::all();
$deleted = 0;
foreach($patients as $patient) {
    if ($patient->user && $patient->user->hasRole('Doctor')) {
        $patient->delete();
        $deleted++;
    }
}
echo "Deleted {$deleted} invalid patient records.\n";
