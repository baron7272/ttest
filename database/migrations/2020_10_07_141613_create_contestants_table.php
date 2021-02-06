<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContestantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contestants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('dpImage')->nullable();
            $table->enum('type', ['Single', 'Group'])->default('Single');
            $table->string('categories')->nullable();
            $table->string('subCategories')->nullable();
            
            $table->enum('status', ['Evicted','Runner', 'Winner','Cancelled','Disqualified','Contestant'])->default('Contestant');
            $table->string('userIds')->nullable();
            $table->string('usersIds')->nullable();
            $table->string('contestant')->nullable(); 

            $table->string('fanBaseName')->nullable(); 
            $table->string('stageName')->nullable(); 
            $table->string('videoUrl')->nullable(); 
            $table->string('about')->nullable();  
            $table->string('week')->nullable();  
            $table->string('image')->nullable(); 
            $table->string('last')->nullable();      
            $table->string('weekVote1')->nullable();    
            $table->string('weekVote2')->nullable();    
            $table->string('weekVote3')->nullable();   
            $table->string('weekVote4')->nullable();   
            $table->string('weekVote5')->nullable();   
            $table->string('weekVote6')->nullable();   
            $table->string('weekVote7')->nullable();   
            $table->string('weekVote8')->nullable();   
            $table->string('weekVote9')->nullable();   
            $table->string('weekVote10')->nullable();   
            $table->string('weekVote11')->nullable();   
            $table->string('weekVote12')->nullable();   
            $table->string('weekVote13')->nullable();   
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contestants');
    }
}
