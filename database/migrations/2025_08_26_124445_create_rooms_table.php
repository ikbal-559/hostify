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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->foreignId('room_type_id')->constrained('room_types')->onDelete('cascade');
            $table->unsignedInteger('availability_status')->default(1); // 1: available, 2: occupied, 3: maintenance
            $table->unsignedInteger('bed_type')->nullable(); // 1: single, 2: double, 3: twin, 4: family
            $table->unsignedInteger('number_of_beds')->default(1);
            $table->text('description')->nullable();
            $table->string('thumbnail')->nullable();
            $table->decimal('price_per_night', 16, 2)->default(0);
            $table->unsignedInteger('capacity')->default(1);            
            $table->unsignedInteger('floor')->nullable();
            $table->float('room_size')->nullable();
            $table->string('view')->nullable();
            $table->boolean('smoking_allowed')->default(false);
            $table->text('special_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
