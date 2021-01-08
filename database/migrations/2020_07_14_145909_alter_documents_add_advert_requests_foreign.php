<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterDocumentsAddAdvertRequestsForeign extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->unsignedBigInteger('advert_request_id')->nullable()->default(null);
        });

        Schema::table('documents', function (Blueprint $table) {
            $table->foreign('advert_request_id')
                ->references('id')
                ->on('advert_requests')
                ->onUpdate('CASCADE')
                ->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropForeign('documents_advert_request_id_foreign');
            $table->dropColumn('advert_request_id');
        });
    }
}
