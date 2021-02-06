<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('userId')->nullable();
            $table->enum('type', ['Naira', 'Dollar'])->default('Naira');
            $table->enum('source', ['Credit', 'Debit'])->default('Debit');
            $table->string('subtitle')->nullable();
            $table->string('oldBalance')->nullable();
            $table->string('newBalance')->nullable();
            $table->string('amount')->nullable();
            $table->string('transferedTo')->nullable();
            $table->string('transferedBy')->nullable();
          
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
        Schema::dropIfExists('wallets');
    }
}
