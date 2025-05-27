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
        Schema::create('trainingcategories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->double('price');
            $table->timestamps();
        });

        // After the training_categories has been created, add the foreign id to training_categories
        // because trainings is created before the training_categories
        Schema::table('trainings', function (Blueprint $table) {
            $table->foreignId('trainingcategory_id')->constrained('trainingcategories')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trainings', function (Blueprint $table) {
            $table->dropForeign('trainingcategory_id');
            $table->dropColumn('trainingcategory_id'); // <- moet deze nog?
        });
        Schema::dropIfExists('trainingcategories');
    }
};
