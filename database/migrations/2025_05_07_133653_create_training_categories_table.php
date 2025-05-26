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
        Schema::create('training_categories', function (Blueprint $table) {
            $table->id();
//            $table->foreignId('training_id')->constrained(); // unique category
            $table->string('name');
            $table->double('price');
            $table->timestamps();
        });

        Schema::table('trainings', function (Blueprint $table) {
            $table->foreignId('training_category_id')->constrained('training_categories')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trainings', function (Blueprint $table) {
            $table->dropForeign('training_category_id');
            $table->dropColumn('training_category_id'); // <- moet deze nog?
        });
        Schema::dropIfExists('training_categories');
    }
};
