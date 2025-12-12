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
        Schema::create('event_location', function (Blueprint $table) {
            $table->unsignedBigInteger('evt_id')->primary();
            $table->text('map_details')->nullable();
            $table->string('evt_loctn_name');
            $table->timestamps();

            $table->foreign('evt_id')->references('evt_id')->on('event')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_location');
    }
};
