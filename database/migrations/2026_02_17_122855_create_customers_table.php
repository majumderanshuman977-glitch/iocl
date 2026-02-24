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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->date('dob');
            $table->string('email')->nullable();
            $table->string('gas_consumer_number')->nullable();
            $table->string('father_spouse_name');
            $table->string('mother_name');
            $table->string('profile_image')->nullable();
            $table->string('house_flat_no');
            $table->string('street');
            $table->string('landmark')->nullable();
            $table->string('city');
            $table->string('district');
            $table->string('state');
            $table->string('pin_code');
            $table->string('mobile_number');
            $table->string('landline')->nullable();
            $table->string('id_number');
            $table->string('ration_card_number')->nullable();
            $table->string('id_front_image')->nullable();
            $table->string('id_back_image')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->boolean('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
