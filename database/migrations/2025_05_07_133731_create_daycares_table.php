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
        Schema::create('daycares', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date');
            $table->timestamps();
        });
        
        Schema::create('daycare_dogs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dog_id')->constrained('dogs');
            $table->foreignId('daycare_id')->constrained('daycares');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daycares');
    }
};
