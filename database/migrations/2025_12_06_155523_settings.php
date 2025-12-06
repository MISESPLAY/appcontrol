<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('module')->nullable();     // Ej: "organigrama", "usuarios", "sistema"
            $table->string('key');                    // Ej: "color_tema", "nivel_acceso"
            $table->text('value')->nullable();        // Puede almacenar JSON, texto largo, etc.
            $table->timestamps();                     // created_at y updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
