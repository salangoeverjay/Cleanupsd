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
        Schema::create('organizer_chart', function (Blueprint $table) {
            $table->id('org_chart_id');
            $table->unsignedBigInteger('org_id');
            $table->integer('month'); // 1-12
            $table->integer('evts_orgzd_count')->default(0);
            $table->integer('totl_partpts_count')->default(0);
            $table->timestamps();

            $table->foreign('org_id')->references('org_id')->on('organizer')->onDelete('cascade');
            $table->unique(['org_id', 'month']); // One record per organizer per month
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizer_chart');
    }
};
