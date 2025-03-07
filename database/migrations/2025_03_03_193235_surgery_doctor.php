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
        Schema::create('surgery_doctor', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('doctor_id');
        $table->unsignedBigInteger('surgery_id');
        $table->unsignedBigInteger('doctor_role_id');
        $table->unsignedBigInteger('invoice_id')->nullable(); 
        $table->bigInteger('amount');
        $table->timestamps();

        $table->foreign('doctor_id')->references('id')->on('doctors');
        $table->foreign('surgery_id')->references('id')->on('surgeries');

        $table->foreign('doctor_role_id')->references('id')->on('doctor_roles');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surgery_doctor');
    }
};
