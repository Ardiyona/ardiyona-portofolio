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
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->string('position');
            $table->string('company');
            $table->string('location');
            $table->enum('work_arrangement', ['fulltime', 'parttime','internship', 'freelance']);
            $table->enum('work_style', ['onsite', 'hybrid', 'remote']);
            $table->boolean('is_currently_working');
            $table->date('work_start');
            $table->date('work_end')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experiences');
    }
};
