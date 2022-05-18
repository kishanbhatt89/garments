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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('razor_plan_id')->unique();
            $table->string('razor_plan_name')->unique();
            $table->text('razor_plan_description')->nullable();
            $table->double('razor_plan_price')->nullable();            
            $table->boolean('razor_plan_is_active')->default(true);
            $table->timestamp('razor_plan_created_at')->nullable();                
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
        Schema::dropIfExists('plans');
    }
};
