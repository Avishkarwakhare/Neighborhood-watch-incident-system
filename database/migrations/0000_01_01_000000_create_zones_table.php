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
        Schema::create('zones', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('city');
            $table->string('state');
            // We will add warden_id later or allow it to be nullable. Since it references users, it's a circular dependency.
            // A zone belongs to a warden (user), and a user belongs to a zone.
            // We'll add the foreign key after users table is created.
            $table->unsignedBigInteger('warden_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zones');
    }
};
