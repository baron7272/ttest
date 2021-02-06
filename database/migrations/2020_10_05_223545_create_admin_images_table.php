<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('contentUrl')->nullable();
            $table->string('uploadedBy')->nullable();
            $table->string('uploadedAt')->nullable();
            $table->enum('type', ['Video', 'Audio','Picture'])->default('Picture');

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
        Schema::dropIfExists('admin_images');
    }
}
