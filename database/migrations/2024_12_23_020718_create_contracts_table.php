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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->foreignId('employee_id')->constrained()->onDelete('cascade'); // Relasi ke employees
            $table->string('transition_no')->unique(); // Nomor transisi
            $table->string('career_transition'); // Transisi karir (misal: Promosi)
            $table->string('transition_type'); // Jenis transisi (Tetap/Kontrak)
            $table->string('position'); // Posisi 
            $table->date('start_date'); // Tanggal mulai kontrak
            $table->date('end_date'); // Tanggal akhir kontrak
            $table->integer('duration')->nullable(); // Lama kontrak (dalam bulan/tahun)
            $table->text('remark')->nullable(); // Catatan tambahan
            $table->timestamps(); // Timestamps (created_at & updated_at)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
