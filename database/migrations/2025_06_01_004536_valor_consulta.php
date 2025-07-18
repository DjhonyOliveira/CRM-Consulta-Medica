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
        Schema::create('valor_consulta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medico_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('especialidade_id')->constrained()->onDelete('cascade');
            $table->decimal('valor', 8, 2);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('valor_consulta');
    }
};
