<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUserAddAdditionalFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone_number2')->nullable()->default(null);
            $table->string('phone_number3')->nullable()->default(null);
            $table->string('messenger')->nullable()->default(null);
            $table->json('specialization');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('phone_number2');
            $table->dropColumn('phone_number3');
            $table->dropColumn('messenger');
            $table->dropColumn('specialization');
        });
    }
}
