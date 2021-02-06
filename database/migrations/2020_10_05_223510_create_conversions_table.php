<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConversionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('type', ['Dollar', 'Naira'])->default('Naira');
            $table->string('value')->nullable();
            $table->string('verifiedBy')->nullable();
            $table->string('verifiedAt')->nullable();
            $table->string('updatedBy')->nullable();
            $table->string('updatedAt')->nullable();
    
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
        Schema::dropIfExists('conversions');
    }
}
