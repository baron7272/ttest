<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSponsorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sponsors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('imageUrl')->nullable();
            $table->string('ownerId')->nullable();
            $table->string('uploadedBy')->nullable();
            $table->string('uploadedTimeBy')->nullable();
            $table->enum('type', ['Video', 'Audio','Picture'])->default('Picture');
            
            $table->string('for')->nullable();
            $table->string('show')->nullable();
            
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
        Schema::dropIfExists('sponsors');
    }
}
