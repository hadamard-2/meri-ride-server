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
        Schema::create('rides', function (Blueprint $table) {
            $table->id();
            $table->foreignId('passenger_id')
                ->constrained('passengers', 'id')
                ->onDelete('cascade');
            $table->foreignId('driver_id')
                ->constrained('drivers', 'id')
                ->onDelete('cascade');
            $table->float('pickup_lat')->nullable(false);
            $table->float('pickup_long')->nullable(false);
            $table->string('pickup_address', 255)->nullable(true);
            $table->float('dropoff_lat')->nullable(false);
            $table->float('dropoff_long')->nullable(false);
            $table->string('dropoff_address', 255)->nullable(true);
            $table->enum('ride_status', ['Requested', 'Accepted', 'Completed', 'Cancelled'])->nullable(false);
            $table->decimal('fare_base', 10, 2)->nullable(false);
            $table->decimal('fare_distance', 10, 2)->nullable(false);
            $table->decimal('fare_total', 10, 2)->nullable(false);
            $table->enum('payment_method', ['Cash', 'Payment Gateway'])->nullable(false);
            $table->integer('ride_duration_minutes')->nullable(true);
            $table->float('distance_km')->nullable(true);
            $table->dateTime('ride_start_time')->nullable(true);
            $table->dateTime('ride_end_time')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rides');
    }
};
