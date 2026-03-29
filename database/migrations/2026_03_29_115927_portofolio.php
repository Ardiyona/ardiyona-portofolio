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
        Schema::create('portofolio', function (Blueprint $table){
            $table->id();
            $table->integer('category_id');
            $table->integer('techStack_id');
            $table->string('title');
            $table->text('description');
            $table->timestamp('date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portofolio');
    }
};
