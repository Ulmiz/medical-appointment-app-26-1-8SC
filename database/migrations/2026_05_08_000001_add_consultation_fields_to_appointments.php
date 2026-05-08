<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->text('diagnostico')->nullable()->after('status');
            $table->text('tratamiento')->nullable()->after('diagnostico');
            $table->text('notas')->nullable()->after('tratamiento');
            $table->json('medicamentos')->nullable()->after('notas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['diagnostico', 'tratamiento', 'notas', 'medicamentos']);
        });
    }
};
