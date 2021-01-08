<?php

use Doctrine\DBAL\Types\FloatType;
use Doctrine\DBAL\Types\Type;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdvertsDoubleValues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Type::hasType('double')) {
            Type::addType('double', FloatType::class);
        }

        Schema::table('adverts', function (Blueprint $table) {
            $table->unsignedDouble('total_area')->nullable()->default(null)->change();
            $table->unsignedDouble('price_usd')->default(null)->change();
            $table->unsignedDouble('price_uah')->default(null)->change();
            $table->unsignedDouble('price_per_ms_usd')->default(null)->change();
            $table->unsignedDouble('price_per_ms_uah')->default(null)->change();
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
            //
        });
    }
}
