<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review_materials', function (Blueprint $table) {
        $table->increments('id');
            $table->integer('lesson_id');
            $table->string('name');
            $table->string('mime_type');
            $table->text('description');
            $table->boolean('is_open')->default(false);
            $table->string('file_name');
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
        Schema::dropIfExists('review_materials');
    }
}
