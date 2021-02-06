<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uploads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('video', ['First','Second','Task','Normal','Intro'])->default('Normal');
          
            $table->string('contentUrl')->nullable();
            $table->string('contentImage')->nullable();
            $table->string('uploadedBy')->nullable();
            $table->string('uploadedAt')->nullable();
            $table->string('uploadedFrom')->nullable();
            
            $table->enum('type', ['Video', 'Audio','Picture'])->default('Video');
            $table->enum('for', ['Single', 'Group','General'])->default('Single');
            $table->string('week')->nullable();
            $table->enum('verified', ['Yes', 'No'])->default('No');
            $table->string('verifiedBy')->nullable();
            $table->string('verifiedAt')->nullable();
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
        Schema::dropIfExists('uploads');
    }
}
