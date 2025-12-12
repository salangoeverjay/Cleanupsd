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
        Schema::create('user', function (Blueprint $table) {
            $table->id('usr_id');
            $table->string('usr_name');
            $table->string('password');
            $table->string('registered_as'); // 'Organizer' or 'Volunteer'
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('user_details', function (Blueprint $table) {
            $table->unsignedBigInteger('usr_id')->primary();
            $table->string('email_add')->unique();
            $table->string('contact_num')->nullable();
            $table->text('address')->nullable();
            $table->timestamps();

            $table->foreign('usr_id')->references('usr_id')->on('user')->onDelete('cascade');
        });

        Schema::create('organizer', function (Blueprint $table) {
            $table->unsignedBigInteger('org_id')->primary();
            $table->string('org_name');
            $table->integer('totl_evts_orgzd')->default(0);
            $table->decimal('totl_trsh_collected_kg', 10, 2)->default(0);
            $table->integer('totl_partpts_overall')->default(0);
            $table->timestamps();

            $table->foreign('org_id')->references('usr_id')->on('user')->onDelete('cascade');
        });

        Schema::create('volunteer', function (Blueprint $table) {
            $table->unsignedBigInteger('vol_id')->primary();
            $table->integer('totl_evts_partd')->default(0);
            $table->integer('evt_curr_joined')->default(0);
            $table->decimal('totl_trash_collected_kg', 10, 2)->default(0);
            $table->timestamps();

            $table->foreign('vol_id')->references('usr_id')->on('user')->onDelete('cascade');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email_add')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('volunteer');
        Schema::dropIfExists('organizer');
        Schema::dropIfExists('user_details');
        Schema::dropIfExists('user');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
