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
        Schema::create('dog_trainings', function (Blueprint $table) {
            $table->foreignId('dog_id')->constrained('dogs');
            $table->foreignId('trainingcategory_id')->constrained('trainingcategories')->cascadeOnDelete();
            $table->timestamp('watched_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dog_trainings');
    }
};
