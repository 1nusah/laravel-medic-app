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
        Schema::create('appointments', function (Blueprint $table) {
            $table->uuid('id',)->primary();
            $table->timestamps();
            $table->softDeletes('deleted_at');
            $table->string('name')->nullable();
            $table->foreignUuid('patient_id')->constrained('users', 'id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained('users', 'id')->onUpdate('cascade')->onDelete('cascade')->nullable();
            $table->string('status')->nullable();
            $table->dateTime('appointment_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
