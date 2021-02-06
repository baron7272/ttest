<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('contestId')->nullable();
            $table->enum('status', ['Winner','Evicted','Spectator','Review', 'Accepted'])->default('Spectator');
         
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('occupation')->nullable();
            $table->string('username')->nullable();
            $table->string('gender')->nullable();
            $table->string('email')->nullable();
            $table->string('about')->nullable();

            $table->string('facebook')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->string('watsap')->nullable();
        
            
            $table->string('phone')->unique();
            $table->string('country')->nullable();
            $table->string('countryCode')->nullable();
            $table->string('age')->nullable();
            $table->string('imageUrl')->nullable();
            $table->string('verifiedAt')->nullable();
            $table->string('password');
            $table->rememberToken();
            
            // $table->timestamp('created_at')->nullable();
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
        Schema::dropIfExists('users');
    }
}
