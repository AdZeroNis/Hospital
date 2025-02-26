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
        Schema::create('roles_doctor', function (Blueprint $table) {
            $table->id();
            $table->string('title', 191)->unique();
            $table->tinyInteger('quota')->default(0)->unsigned()->comment('Percentage share in surgery (0 to 100)');
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles_doctor');
    }
};
