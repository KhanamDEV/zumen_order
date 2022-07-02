<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('postal_code')->nullable();
            $table->longText('additional')->nullable();
            $table->json('url_additional')->default(json_encode([]))->nullable();
            $table->json('documents_additional')->default(json_encode([]))->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('postal_code');
            $table->dropColumn('additional');
            $table->dropColumn('url_additional');
            $table->dropColumn('documents_additional');
        });
    }
}
