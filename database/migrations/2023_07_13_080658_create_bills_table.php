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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->string('customer_account_number', 10); // I just provided a char limit even though there isn't one in the instruction.
            $table->string('invoice_number', 10); // I just provided a char limit even though there isn't one in the instruction.
            $table->string('site_id', 10); // alpanumeric 10 chars long based on instruction
            $table->date('bill_start_date');
            $table->date('bill_end_date');
            $table->decimal('amount', 8, 2); // I just provided the decimal places even though there isn't one in the instruction.
            $table->integer('electricity_usage'); // Since there are no instruction I just based this on what I see on my electrivity bills per kwh which is a whole number.

            $table->foreign('site_id')->references('id')->on('sites');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
