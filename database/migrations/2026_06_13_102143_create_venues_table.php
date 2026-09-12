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
    Schema::create('venues', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->text('description');
        $table->integer('capacity');
        $table->string('location');
        $table->json('amenities')->nullable();
        $table->decimal('price_per_hour', 10, 2);
        $table->json('images')->nullable();
        $table->boolean('is_available')->default(true);
        $table->string('opening_time')->default('09:00');
        $table->string('closing_time')->default('18:00');
        $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venues');
    }
};
