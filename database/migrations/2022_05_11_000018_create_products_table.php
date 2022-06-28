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
            $table->string('sku')->unique();
            $table->string('name');
            $table->mediumText('image')->nullable();
            $table->mediumText('image_uploaded_url')->nullable();
            $table->text('details');
            $table->foreignId('category_id')->nullable()->constrained();
            $table->unsignedBigInteger('subcategory_id');
            $table->string('variation_type');
            $table->string('brand');
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
