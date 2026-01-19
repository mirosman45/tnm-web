<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('full_description')->nullable();
            $table->date('date');
            $table->time('time')->nullable();
            $table->string('location');
            $table->string('venue')->nullable();
            $table->string('organizer')->nullable();
            $table->json('speakers')->nullable();
            $table->json('agenda')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('website')->nullable();
            $table->string('image')->nullable();
            $table->unsignedInteger('views')->default(0);
            $table->enum('status', ['draft', 'published', 'cancelled'])->default('draft');
            $table->timestamps();
            // MAKE SURE THIS LINE IS NOT HERE: $table->softDeletes();
            
            // Indexes
            $table->index('slug');
            $table->index('date');
            $table->index('status');
            $table->index(['status', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};