<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAdvertsTableAddMissingFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('adverts', function (Blueprint $table) {
            $table->string('street')->default(null);
            $table->string('building')->default(null);
            $table->string('city')->default(null);
            $table->string('district')->default(null);
            $table->string('microdistrict')->default(null);
            $table->unsignedDouble('total_area')->default(null);
            $table->unsignedDouble('living_area')->default(null);
            $table->unsignedDouble('kitchen_area')->default(null);
            $table->boolean('has_repair')->default(0);
            $table->string('construction_type')->default(null);
            $table->string('wall_material')->default(null);
            $table->unsignedSmallInteger('construction_year')->default(null);
            $table->string('building_type')->default(null);
            $table->text('description')->default(null);
            $table->string('title')->default(null);
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
            $table->dropColumn('street');
            $table->dropColumn('building');
            $table->dropColumn('city');
            $table->dropColumn('district');
            $table->dropColumn('microdistrict');
            $table->dropColumn('total_area');
            $table->dropColumn('living_area');
            $table->dropColumn('kitchen_area');
            $table->dropColumn('has_repair');
            $table->dropColumn('construction_type');
            $table->dropColumn('wall_material');
            $table->dropColumn('construction_year');
            $table->dropColumn('building_type');
            $table->dropColumn('description');
            $table->dropColumn('title');
        });
    }
}
