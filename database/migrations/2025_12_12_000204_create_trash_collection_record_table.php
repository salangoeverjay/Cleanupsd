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
        Schema::create('trash_collection_record', function (Blueprint $table) {
            $table->id('record_id');
            $table->unsignedBigInteger('vol_id');
            $table->unsignedBigInteger('evt_id');
            $table->decimal('trash_collected_kg', 10, 2)->default(0);
            $table->timestamps();

            $table->foreign('vol_id')->references('vol_id')->on('volunteer')->onDelete('cascade');
            $table->foreign('evt_id')->references('evt_id')->on('event')->onDelete('cascade');
            
            // Ensure a volunteer can only report once per event
            $table->unique(['vol_id', 'evt_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trash_collection_record');
    }
};
