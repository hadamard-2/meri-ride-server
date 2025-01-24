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
        Schema::create('driver_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_id')
                ->constrained('drivers', 'id')
                ->onDelete('cascade');
            $table->string('vehicle_ownership')->nullable(false);
            $table->string('libre')->nullable(false);
            $table->string('insurance')->nullable(false);
            $table->string('business_registration')->nullable(false);
            $table->string('business_license')->nullable(false);
            $table->string('tin_number', 50)->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('driver_documents');
    }
};
