<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('states', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->nullable();
            $table->timestamps();
        });

        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('state_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('pincode_prefix')->nullable();
            $table->timestamps();
        });

        // Since we already have localities/societies tables from the previous chunk, 
        // we'll modify them. However, since we run migrate:fresh, it's easier to drop them if they exist and recreate.
        Schema::dropIfExists('societies');
        Schema::dropIfExists('localities');

        Schema::create('localities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('city_id')->constrained()->cascadeOnDelete();
            $table->foreignId('zone_id')->nullable()->constrained()->nullOnDelete(); // keep zone_id for legacy compatibility
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('societies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('locality_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('type')->nullable();
            $table->string('landmark')->nullable();
            $table->string('pincode')->nullable();
            $table->decimal('lat', 10, 8)->nullable();
            $table->decimal('lng', 11, 8)->nullable();
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('state_id')->nullable()->constrained('states')->nullOnDelete();
            $table->foreignId('city_id')->nullable()->constrained('cities')->nullOnDelete();
            if (!Schema::hasColumn('users', 'locality_id')) {
                $table->foreignId('locality_id')->nullable()->constrained('localities')->nullOnDelete();
                $table->foreignId('society_id')->nullable()->constrained('societies')->nullOnDelete();
                $table->string('house_no')->nullable();
                $table->string('full_address')->nullable();
            }
        });

        Schema::table('incidents', function (Blueprint $table) {
            $table->foreignId('state_id')->nullable()->constrained('states')->nullOnDelete();
            $table->foreignId('city_id')->nullable()->constrained('cities')->nullOnDelete();
            if (!Schema::hasColumn('incidents', 'locality_id')) {
                $table->foreignId('locality_id')->nullable()->constrained('localities')->nullOnDelete();
                $table->foreignId('society_id')->nullable()->constrained('societies')->nullOnDelete();
            }
        });
    }

    public function down()
    {
        // ...
    }
};