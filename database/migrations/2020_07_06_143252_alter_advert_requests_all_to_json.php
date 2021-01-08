<?php

use Doctrine\DBAL\Types\FloatType;
use Doctrine\DBAL\Types\Type;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAdvertRequestsAllToJson extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('advert_requests', function (Blueprint $table) {
            $table->dropColumn('city');
            $table->dropColumn('district');
            $table->dropColumn('microdistrict');
            $table->dropColumn('description');
            $table->dropColumn('notes');
            $table->dropColumn('type');
            $table->dropColumn('property_type');
            $table->dropColumn('total_area');
            $table->dropColumn('total_area_min');
            $table->dropColumn('total_area_max');
            $table->dropColumn('price_usd');
            $table->dropColumn('price_usd_min');
            $table->dropColumn('price_usd_max');
            $table->dropColumn('price_uah');
            $table->dropColumn('price_uah_min');
            $table->dropColumn('price_uah_max');
            $table->dropColumn('street');
            $table->dropColumn('region');
            $table->dropColumn('has_repair');
            $table->dropColumn('title');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(!Type::hasType('double')) {
            Type::addType('double', FloatType::class);
        }

        Schema::table('advert_requests', function (Blueprint $table) {
            $table->string('city')->nullable()->default(null);
            $table->string('district')->nullable()->default(null);
            $table->string('microdistrict')->nullable()->default(null);
            $table->text('description')->nullable()->default(null);

            $table->text('notes')->default(null);
            $table->string('type')->nullable()->default(null);
            $table->string('property_type')->nullable()->default(null);

            $table->unsignedDouble('total_area')->nullable()->default(null);
            $table->unsignedDouble('total_area_min')->nullable()->default(null);
            $table->unsignedDouble('total_area_max')->nullable()->default(null);
            $table->unsignedDouble('price_usd')->nullable()->default(null);
            $table->unsignedDouble('price_usd_min')->nullable()->default(null);
            $table->unsignedDouble('price_usd_max')->nullable()->default(null);
            $table->unsignedDouble('price_uah')->nullable()->default(null);
            $table->unsignedDouble('price_uah_min')->nullable()->default(null);
            $table->unsignedDouble('price_uah_max')->nullable()->default(null);
            $table->string('region')->after('city')->nullable(true)->default(null);
            $table->string('street')->nullable(true)->default(null);
            $table->boolean('has_repair')->nullable(true)->default(0);
            $table->string('title')->default('');
        });
    }
}
