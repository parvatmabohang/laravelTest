<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePattributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pattributes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->string('sku');
            $table->string('size');
            $table->float('price');
            $table->integer('stock');  
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
        Schema::dropIfExists('pattributes');
    }
}
