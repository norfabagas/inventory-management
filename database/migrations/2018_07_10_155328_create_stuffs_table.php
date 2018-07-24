<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStuffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stuffs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->text('condition');
            $table->text('location');
            $table->string('size')->nullable();
            $table->text('detail')->nullable();
            $table->integer('quantity');
            $table->timestamps();
        });

        DB::table('stuffs')->insert([
          [
            'name' => 'T-Shirt',
            'category_id' => 1,
            'condition' => 'New',
            'location' => 'Semarang',
            'size' => 'XL',
            'detail' => 'Shirt for giveaway',
            'quantity' => 10,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
          ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stuffs');
    }
}
