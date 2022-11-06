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
            $table->string('id')->primary();
            $table->enum('grosorBase', ['K','F']);
            $table->enum('grosorPunta', ['2','3','4']);
            $table->enum('tipo', ['conical','two pieces']);
            $table->enum('material', ['gold','inox']);
            $table->enum('forma', ['straight','inclined']);

            
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
