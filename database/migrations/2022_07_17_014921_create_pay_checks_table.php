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
        Schema::create('pay_checks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('site');
            $table->decimal('amount');
            $table->date('from');
            $table->date('to');
            $table->boolean('is_paid');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pay_checks');
    }
};
