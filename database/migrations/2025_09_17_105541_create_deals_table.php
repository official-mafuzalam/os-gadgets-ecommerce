<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('deals', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('discount_text')->nullable();
            $table->integer('discount_percentage')->nullable();
            $table->string('discount_details')->nullable();
            $table->string('button_text')->default('Shop Now');
            $table->string('button_link');
            $table->string('image_url');
            $table->string('background_from_color')->default('#4f46e5'); // indigo-600
            $table->string('background_to_color')->default('#9333ea'); // purple-600
            $table->boolean('is_active')->default(true);
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->integer('priority')->default(0);
            $table->timestamps();

            // Index for better performance when querying active deals
            $table->index(['is_active', 'starts_at', 'ends_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deals');
    }
};
