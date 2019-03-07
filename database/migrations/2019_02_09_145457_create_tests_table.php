<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tests', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('lesson_id')->nullable();
            $table->foreign('lesson_id')->references('id')->on('lessons')->onDelete('cascade');
            $table->unsignedInteger('module_id')->nullable();
            $table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade');
            $table->string('name');
            $table->double('passing_grade');
            $table->string('type');
            $table->boolean('is_open')->default(false);
            $table->unsignedInteger('time_limit')->default(10);
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
        Schema::dropIfExists('tests');
    }
}
