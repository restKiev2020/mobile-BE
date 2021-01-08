<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAdvertRequestsDateViewed extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_advert_requests', function (Blueprint $table) {
            $table->timestamp('requested_time')->nullable(false);
            $table->boolean('viewed')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_advert_requests', function (Blueprint $table) {
            $table->dropColumn('requested_time');
            $table->dropColumn('viewed');
        });
    }
}
