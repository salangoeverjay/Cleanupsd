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
        Schema::create('event_participation', function (Blueprint $table) {
            $table->id('partptn_id');
            $table->unsignedBigInteger('vol_id');
            $table->unsignedBigInteger('evt_id');
            $table->string('status')->default('pending'); // pending, confirmed, attended
            $table->timestamps();

            $table->foreign('vol_id')->references('vol_id')->on('volunteer')->onDelete('cascade');
            $table->foreign('evt_id')->references('evt_id')->on('event')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_participation');
    }
};
