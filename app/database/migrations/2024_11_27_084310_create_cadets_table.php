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
        Schema::create('cadets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('cadet_identifier')->nullable();
            $table->enum('gender', ['male', 'female']);
            $table->integer('age');
            $table->date('dob');
            $table->string('address');
            $table->string('course');
            $table->string('religion');
            $table->string('b_type');
            $table->string('height');
            $table->string('beneficiary');
            $table->string('email')->nullable();
            $table->foreignId('class_year_id')->constrained('class_years')->onDelete('cascade');
            $table->string('subject');
            $table->float('sem_1_grade')->nullable();
            $table->float('sem_2_grade')->nullable();
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cadets');
    }
};
