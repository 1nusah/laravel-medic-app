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
        Schema::create('organizations', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('name');
            $table->string('phoneNumber')->unique();
            $table->string('email')->unique();
            $table->string('ghanaPostAddress');
            $table->softDeletes('deleted_at');
            $table->timestamps();
            $table->timestamp('email_verified_at')->nullable();

        });

        Schema::table('organizations', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('organizations', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};
