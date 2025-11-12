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
    Schema::create('organizacion', function (Blueprint $table) {
        $table->id(); // equivale al campo 'id' de tu array
        $table->string('name'); // nombre del empleado
        $table->unsignedBigInteger('report_to')->nullable(); // jefe al que reporta
        $table->string('title'); // puesto o cargo
        $table->string('department'); // departamento al que pertenece
        $table->timestamps(); // created_at y updated_at

        // clave foránea para jerarquía (empleado reporta a otro empleado)
        $table->foreign('report_to')
              ->references('id')
              ->on('organizacion')
              ->onDelete('set null');
    });
}


    /**
     * Reverse the migrations.
     */
   public function down(): void
{
    Schema::dropIfExists('organizacion');
}

};
