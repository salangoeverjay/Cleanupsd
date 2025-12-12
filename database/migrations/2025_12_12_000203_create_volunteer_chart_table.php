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
        Schema::create('volunteer_chart', function (Blueprint $table) {
            $table->id('vol_chart_id');
            $table->unsignedBigInteger('vol_id');
            $table->integer('month'); // 1-12
            $table->integer('evts_partd_count')->default(0);
            $table->decimal('trash_collected_kg', 10, 2)->default(0);
            $table->timestamps();

            $table->foreign('vol_id')->references('vol_id')->on('volunteer')->onDelete('cascade');
            $table->unique(['vol_id', 'month']); // One record per volunteer per month
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('volunteer_chart');
    }
};
