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
        Schema::create('sites', function (Blueprint $table) {
            $table->string('id', 10)->primary();
            $table->string('name', 60); // I just provided a char limit even though there isn't one in the instruction.
            $table->string('address', 80); // I just provided a char limit even though there isn't one in the instruction.
            $table->unsignedBigInteger('site_manager_id');

            // Foreign key constraint
            $table->foreign('site_manager_id')->references('id')->on('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sites');
    }
};
