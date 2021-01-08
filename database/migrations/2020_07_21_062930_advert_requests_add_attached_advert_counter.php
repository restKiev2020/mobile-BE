<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdvertRequestsAddAttachedAdvertCounter extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('advert_requests', function (Blueprint $table) {
            $table->unsignedInteger('attached_adverts')->nullable(false)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('advert_requests', function (Blueprint $table) {
            $table->dropColumn('attached_adverts');
        });
    }
}
