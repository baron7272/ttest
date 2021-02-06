<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('model', ['Group', 'Single','Public'])->default('Public');        
            $table->enum('readMessages', ['Yes', 'No'])->default('No');        
            $table->string('contentUrl')->nullable();
            $table->string('contentImage')->nullable();
            $table->string('title')->nullable();
            $table->string('content')->nullable();
            $table->string('value')->nullable();    
            $table->enum('type', ['Request','Text','Video', 'Audio','Picture'])->default('Video');        
          
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
        Schema::dropIfExists('notifications');
    }
}
