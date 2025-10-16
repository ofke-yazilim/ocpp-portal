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
        if(!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('username')->nullable();
                $table->string('name')->nullable();
                $table->string('surname')->nullable();
                $table->string('email')->unique();
                $table->string('role');
                $table->string('site_id')->nullable();
                $table->string('apartment_id')->nullable();
                $table->string('ip')->nullable();
                $table->text('data')->nullable();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->rememberToken();
                $table->timestamps();
            });
        }

        if(!Schema::hasTable('rfid_cards')) {
            Schema::create('rfid_cards', function (Blueprint $table) {
                $table->string('id')->primary();
                $table->foreignId('user_id')->index();
                $table->integer('uid')->index();
                $table->string('site_id')->nullable();
                $table->integer('status')->index();
                $table->timestamps();
            });
        }

        if(!Schema::hasTable('password_reset_tokens')) {
            Schema::create('password_reset_tokens', function (Blueprint $table) {
                $table->string('email')->primary();
                $table->string('token');
                $table->timestamp('created_at')->nullable();
            });
        }

        if(!Schema::hasTable('sessions')) {
            Schema::create('sessions', function (Blueprint $table) {
                $table->string('id')->primary();
                $table->foreignId('user_id')->nullable()->index();
                $table->string('ip_address', 45)->nullable();
                $table->text('user_agent')->nullable();
                $table->longText('payload');
                $table->integer('last_activity')->index();
            });
        }

        if(!Schema::hasTable('sites')) {
            Schema::create('sites', function (Blueprint $table) {
                $table->string('id')->primary();
                $table->string('name');
                $table->string('location');
                $table->text('address');
                $table->integer('status')->index()->default(1);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('rfid_cards');
        Schema::dropIfExists('sites');
    }
};
