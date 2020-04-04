<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');

            $table->string('code')->unique();
            $table->string('name')->unique()->index();

            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->tinyInteger('status');
            $table->boolean('is_tenant')->nullable();

            $table->integer('created_by')->unsigned()->index()->nullable();
            $table->foreign('created_by')->references('id')->on('users');

            $table->integer('updated_by')->unsigned()->index()->nullable();
            $table->foreign('updated_by')->references('id')->on('users');

            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
