<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_endpoints', function (Blueprint $table) {
            $table->id();
            $table->boolean('active')->default(true);;
            $table->string('slug')->unique();;
            $table->text('url');
            $table->float('previous_price')->nullable();
            $table->float('current_price')->nullable();
            $table->timestamps();
        });

        Schema::create('price_endpoint_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('price_endpoint_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('price_endpoint_id')->references('id')->on('price_endpoints')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('price_endpoint_user');
        Schema::dropIfExists('price_endpoints');
    }
};
