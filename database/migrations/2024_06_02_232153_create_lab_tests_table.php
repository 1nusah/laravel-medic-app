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
        Schema::create('lab_tests', function (Blueprint $table) {
            $table->uuid('id',)->primary();
            $table->timestamps();
            $table->softDeletes('deleted_at');
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('diagnosis')->nullable();
            $table->foreignUuid('diagnosis_id')->constrained('diagnoses', 'id')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->string('file_key')->nullable();
            $table->string('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_tests');
    }
};
