<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTable1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        schema::create('table',function (Blueprint $table){
            $table->increments('id');
            $table->string('name')->nullable();
            $table->text('article');
            $table->string('username',12)->unique();
        });
        Schema::rename('table','table1');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        schema::drop('table1');
    }
}
