<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Doctrine\DBAL\Types\FloatType;
use Doctrine\DBAL\Types\Type;

class AdvertRequestsTableEverythingDefault extends Migration
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

        Schema::table('advert_requests', function (Blueprint $table) {
            $table->string('city')->nullable()->default(null)->change();
            $table->string('district')->nullable()->default(null)->change();
            $table->string('microdistrict')->nullable()->default(null)->change();
            $table->text('description')->nullable()->default(null)->change();

            $table->text('notes')->default(null)->change();
            $table->string('type')->nullable()->default(null)->change();
            $table->string('property_type')->nullable()->default(null)->change();

            $table->unsignedDouble('total_area')->nullable()->default(null)->change();
            $table->unsignedDouble('total_area_min')->nullable()->default(null)->change();
            $table->unsignedDouble('total_area_max')->nullable()->default(null)->change();
            $table->unsignedDouble('price_usd')->nullable()->default(null)->change();
            $table->unsignedDouble('price_usd_min')->nullable()->default(null)->change();
            $table->unsignedDouble('price_usd_max')->nullable()->default(null)->change();
            $table->unsignedDouble('price_uah')->nullable()->default(null)->change();
            $table->unsignedDouble('price_uah_min')->nullable()->default(null)->change();
            $table->unsignedDouble('price_uah_max')->nullable()->default(null)->change();

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
            //
        });
    }
}
