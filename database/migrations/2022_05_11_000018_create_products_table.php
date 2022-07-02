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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->nullable()->constrained();
            $table->foreignId('store_id')->nullable()->constrained(); 
            $table->string('sku')->nullable();
            $table->string('name');            
            $table->text('details');
            $table->foreignId('category_id')->nullable()->constrained();
            $table->unsignedBigInteger('subcategory_id');
            $table->string('variation_type');
            $table->string('brand')->nullable();
            $table->string('status');
            $table->timestamp('last_edited_date')->nullable();
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
        Schema::dropIfExists('products');
    }
};
