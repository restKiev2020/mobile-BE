<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAdvertsTablePrices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('adverts', function (Blueprint $table) {

            $table->dropColumn('price');
            $table->dropColumn('price_sign');
            $table->dropColumn('price_per_ms');
            $table->dropColumn('price_per_ms_sign');

            $table->unsignedDouble('price_usd')->nullable()->default(null);
            $table->unsignedDouble('price_uah')->nullable()->default(null);
            $table->unsignedDouble('price_per_ms_usd')->nullable()->default(null);
            $table->unsignedDouble('price_per_ms_uah')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('adverts', function (Blueprint $table) {
            $table->dropColumn('price_usd');
            $table->dropColumn('price_uah');
            $table->dropColumn('price_per_ms_usd');
            $table->dropColumn('price_per_ms_uah');

            $table->unsignedInteger('price')->nullable(false);
            $table->char('price_sign', 3)->nullable(false);
            $table->unsignedDouble('price_per_ms')->default(null);
            $table->char('price_per_ms_sign', 3)->nullable(false);
        });
    }
}
