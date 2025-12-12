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
        Schema::create('event', function (Blueprint $table) {
            $table->id('evt_id');
            $table->unsignedBigInteger('org_id');
            $table->string('evt_name');
            $table->date('evt_date');
            $table->text('evt_details')->nullable();
            $table->decimal('trsh_collected_kg', 10, 2)->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('org_id')->references('org_id')->on('organizer')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event');
    }
};
