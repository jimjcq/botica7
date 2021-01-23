<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id');
            $table->double('price_unit');
            $table->double('price_sale');
            $table->integer('quantity');
            $table->foreignId('promotion_id')->nullable();
            $table->foreignId('product_id')->nullable();

            $table->foreign('sale_id')->references('id')->on('sales');
            $table->foreign('promotion_id')->references('id')->on('promotions');
            $table->foreign('product_id')->references('id')->on('products');

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
        Schema::dropIfExists('product_sales');
    }
}
