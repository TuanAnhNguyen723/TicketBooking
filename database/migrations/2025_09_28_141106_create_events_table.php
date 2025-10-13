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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->text('short_description');
            $table->string('image')->nullable();
            $table->json('gallery')->nullable(); // Bộ sưu tập ảnh
            $table->decimal('adult_price', 10, 2);
            $table->decimal('child_price', 10, 2);
            $table->string('location');
            $table->date('start_date');
            $table->date('end_date');
            $table->time('opening_time');
            $table->time('closing_time');
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
