<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_otps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->nullable()->constrained();                        
            $table->string('phone');
            $table->string('otp');
            $table->longText('otp_token');
            $table->string('verification_for');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_otps');
    }
};
