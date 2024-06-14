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
    Schema::create('diagnoses', function (Blueprint $table) {
      $table->uuid('id',)->primary();
      $table->timestamps();
      $table->softDeletes('deleted_at');
      $table->string('symptoms');
      $table->string('tests')->nullable();
      $table->json('prescription');
      $table->string('notes')->nullable();
      $table->foreignUuid('appointment_id')->constrained('appointments')->cascadeOnDelete()->cascadeOnUpdate();

//            change this to have many tests/tests results as well as file keys
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('diagnostics');
  }
};
