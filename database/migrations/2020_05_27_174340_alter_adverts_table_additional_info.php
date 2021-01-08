<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAdvertsTableAdditionalInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('adverts',  function (Blueprint $table) {
            $table->string('type')->nullable(false);
            $table->json('advert_details')->nullable(true);
            $table->string('property_type')->nullable(false);

            $table->dropColumn('construction_year');
            $table->dropColumn('wall_material');
            $table->dropColumn('storeys');
            $table->dropColumn('floor');
            $table->dropColumn('rooms');
            $table->dropColumn('living_area');
            $table->dropColumn('kitchen_area');
            $table->dropColumn('construction_type');
            $table->dropColumn('apartment_number');
            $table->dropColumn('entrance');
            $table->dropColumn('building_type');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('adverts',  function (Blueprint $table) {
            //
        });
    }
}
