<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFaqsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faqs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('category_id')->unsigned();
            $table->bigInteger('location_id')->unsigned();
            $table->bigInteger('language_id')->unsigned()->nullable();
            $table->text('question')->nullable();
            $table->text('answer')->nullable();
            $table->string('image', 500)->nullable();
            $table->string('ref_url', 500)->nullable();
            $table->text('video_id')->nullable();
            $table->string('asked_by')->nullable();
            $table->string('email')->nullable();
            $table->bigInteger('views')->nullable();
            $table->bigInteger('likes')->nullable();
            $table->integer('mail')->default('0');
            $table->integer('status')->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->foreign('category_id')
                  ->references('id')->on('faq_categories')
                  ->onDelete('cascade');
            $table->foreign('location_id')
                  ->references('id')->on('locations')
                  ->onDelete('cascade');
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
        Schema::dropIfExists('faqs');
    }
}
