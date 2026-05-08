<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            if (!Schema::hasColumn('appointments', 'tratamiento')) {
                $table->text('tratamiento')->nullable()->after('diagnostico');
            }
            if (!Schema::hasColumn('appointments', 'notas')) {
                $table->text('notas')->nullable()->after('tratamiento');
            }
            if (!Schema::hasColumn('appointments', 'medicamentos')) {
                $table->json('medicamentos')->nullable()->after('notas');
            }
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            if (Schema::hasColumn('appointments', 'tratamiento')) {
                $table->dropColumn('tratamiento');
            }
            if (Schema::hasColumn('appointments', 'notas')) {
                $table->dropColumn('notas');
            }
            if (Schema::hasColumn('appointments', 'medicamentos')) {
                $table->dropColumn('medicamentos');
            }
        });
    }
};
