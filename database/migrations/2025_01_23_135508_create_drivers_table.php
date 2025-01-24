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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('phone_number', 15)->unique()->nullable(false);
            $table->string('city', 50)->nullable(false);
            $table->string('first_name', 50)->nullable(false);
            $table->string('last_name', 50)->nullable(false);
            $table->string('profile_photo')->nullable(false);
            $table->string('vehicle_make', 50)->nullable(false);
            $table->string('vehicle_model', 50)->nullable(false);
            $table->string('vehicle_color', 30)->nullable(false);
            $table->integer('vehicle_year')->nullable(false);
            $table->string('license_plate', 20)->unique()->nullable(false);
            $table->string('license_number', 30)->nullable(false);
            $table->string('license_country', 50)->nullable(false);
            $table->date('license_issue_date')->nullable(false);
            $table->date('license_expiry_date')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
