<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adverts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('productDesription')->nullable();
            $table->string('productImage')->nullable();
            $table->string('companyLogo')->nullable();
            $table->string('companyName')->nullable();
            $table->string('companyBanner')->nullable(); 
            $table->string('verifiedAt')->nullable(); 
            $table->string('verifiedBy')->nullable();      
            $table->string('durationFrom')->nullable();      
            $table->string('durationTo')->nullable();   
            $table->string('facebook')->nullable();   
            $table->string('whatsapp')->nullable();   
            $table->string('twitter')->nullable();   
            $table->string('tiktok')->nullable();   
            $table->string('instagram')->nullable();   
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
        Schema::dropIfExists('adverts');
    }
}
