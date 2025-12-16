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
        Schema::create('boom_lifts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('model')->nullable();
            $table->text('description')->nullable();
            $table->json('specifications')->nullable();
            $table->string('image')->nullable();
            $table->decimal('hourly_rate', 10, 2);
            $table->decimal('daily_rate', 10, 2);
            $table->decimal('monthly_rate', 10, 2);
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boom_lifts');
    }
};
