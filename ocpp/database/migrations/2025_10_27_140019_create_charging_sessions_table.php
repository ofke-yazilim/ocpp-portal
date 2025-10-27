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
        if(!Schema::hasTable('charging_sessions')) {
            Schema::create('charging_sessions', function (Blueprint $table) {
                $table->id(); // id
                $table->foreignId('user_id')->nullable(); // user_id
                $table->foreignId('rfid_card_id')->nullable(); // rfid_card_id
                $table->foreignId('station_id')->nullable(); // station_id
                $table->timestamp('start_time')->nullable(); // start_time
                $table->timestamp('end_time')->nullable(); // end_time
                $table->enum('status', ['active', 'completed', 'failed'])->default('active'); // status
                $table->decimal('energy_delivered', 8, 2)->nullable(); // energy_delivered (kWh)
                $table->timestamps(); // created_at, updated_at
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('charging_sessions');
    }
};
