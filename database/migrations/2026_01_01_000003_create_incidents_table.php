<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('incidents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('zone_id')->constrained('zones')->onDelete('cascade');
            $table->string('title', 150);
            $table->text('description');
            $table->enum('category', [
                'theft', 'fire', 'accident', 'suspicious_activity',
                'vandalism', 'medical', 'natural_disaster', 'other'
            ]);
            $table->enum('severity', ['low', 'medium', 'high', 'critical']);
            $table->enum('status', ['pending', 'processing', 'verified', 'resolved', 'rejected', 'closed'])->default('pending');
            $table->string('location_address', 255);
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->boolean('is_anonymous')->default(false);
            $table->timestamp('resolved_at')->nullable();
            $table->text('official_note')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incidents');
    }
};
