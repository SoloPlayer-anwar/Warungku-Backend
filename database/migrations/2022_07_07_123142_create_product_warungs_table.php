<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductWarungsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_warungs', function (Blueprint $table) {
            $table->id();
            $table->string('name_warung')->nullable();
            $table->string('alamat_warung')->nullable();
            $table->double('lat')->nullable();
            $table->double('long')->nullable();
            $table->text('photo_warung')->nullable();
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
        Schema::dropIfExists('product_warungs');
    }
}
