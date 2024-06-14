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
    Schema::create('role_user', function (Blueprint $table) {

      $table->uuid('id')->primary();
      $table->timestamps();
      $table->softDeletes('deleted_at');
      $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
      $table->foreignUuid('role_id')->constrained('roles')->cascadeOnDelete()->cascadeOnUpdate();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('role_user');
  }
};
