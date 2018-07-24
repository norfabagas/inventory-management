<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDropsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drops', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('stuff_id');
            $table->foreign('stuff_id')->references('id')->on('stuffs')->onDelete('cascade');
            $table->text('detail');
            $table->integer('quantity');
            $table->string('person');
            // $table->unsignedInteger('person_id');
            $table->timestamps();
        });

        DB::table('drops')->insert([
          [
            'stuff_id' => 1,
            'detail' => 'For giveaway',
            'quantity' => 5,
            'person' => 'Andy',
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
        Schema::dropIfExists('drops');
    }
}
