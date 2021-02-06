<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('votedBy')->nullable();
            $table->string('voted')->nullable();
            $table->string('voteCount')->nullable();
            $table->string('week')->nullable();
            $table->string('verifiedBy')->nullable(); 
            $table->string('verifiedAt')->nullable(); 
            $table->string('verifiedCompany')->nullable();         
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
        Schema::dropIfExists('votes');
    }
}
