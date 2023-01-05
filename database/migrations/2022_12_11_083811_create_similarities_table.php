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
        Schema::dropIfExists('similarities');
        Schema::create('similarities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('book_1')->unsigned()->nullable(); 
            $table->bigInteger('book_2')->unsigned()->nullable(); 
            $table->bigInteger('member_1')->unsigned()->nullable(); 
            $table->bigInteger('member_2')->unsigned()->nullable(); 
            // $table->boolean('method'); //0=userbased,1=itembased
            $table->float('value'); 
            $table->timestamps();
            $table->foreign('book_1')->references('id')->on('books')->onDelete('cascade');
            $table->foreign('book_2')->references('id')->on('books')->onDelete('cascade');
            $table->foreign('member_1')->references('id')->on('members')->onDelete('cascade');
            $table->foreign('member_2')->references('id')->on('members')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('similarities');
    }
};
