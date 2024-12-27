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
        Schema::create('employee_documents', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->foreignId('employee_id')->constrained()->onDelete('cascade'); // Relasi ke employees
            $table->string('document_name'); // Nama dokumen
            $table->string('file_path'); // Path file dokumen di server
            $table->timestamp('uploaded_at')->useCurrent(); // Waktu upload dokumen
            $table->timestamps(); // Timestamps (created_at & updated_at)
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_documents');
    }
};
