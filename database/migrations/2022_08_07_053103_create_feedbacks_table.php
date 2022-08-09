<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id')->nullable();
            $table->dateTime('project_created_at')->nullable();
            $table->string('name')->nullable();
            $table->string('owner')->nullable();
            $table->string('type')->nullable();
            $table->integer('worker_id')->nullable();
            $table->date('delivery_date')->nullable();
            $table->date('finish_day')->nullable();
            $table->json('url')->nullable();
            $table->longText('note')->nullable();
            $table->json('documents')->nullable();
            $table->string('postal_code')->nullable();
            $table->longText('additional')->nullable();
            $table->json('url_additional')->nullable();
            $table->json('documents_additional')->nullable();
            $table->boolean('importunate')->nullable();
            $table->json('documents_of_worker')->nullable();
            $table->json('other_information')->nullable();
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
        Schema::dropIfExists('feedbacks');
    }
}
