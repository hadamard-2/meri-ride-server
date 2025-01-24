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
        Schema::create('driver_statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_id')
                ->constrained('drivers', 'id')
                ->onDelete('cascade');
            $table->enum('status', ['Online', 'Offline', 'On Trip'])->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('driver_statuses');
    }
};
