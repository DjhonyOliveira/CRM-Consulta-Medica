<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('horarios_disponiveis', function (Blueprint $table) {
            $table->foreignId('especialidade_id')->constrained('especialidades');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('horarios_disponiveis', function (Blueprint $table) {
            $table->dropColumn('especialidade_id');
        });
    }
};
