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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('thumbnail')->nullable();
            $table->decimal('price',10,2)->default(0);
            $table->enum('level',[
                'beginner',
                'intermediate',
                'advanced',
            ]);
            $table->foreignId('category_id')->constrained()-casecadeOnDelete();
            $table->foreignId('instructor_id')->constrained()-casecadeOnDelete();
            $table->boolean('is_published')->default(false);
            $table->timestamps('published_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
