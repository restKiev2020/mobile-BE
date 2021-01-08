<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvertRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advert_requests', function(Blueprint $table) {
            $table->id();
            $table->string('street')->nullable(true)->default(null);
            $table->string('city')->nullable(true)->default(null);
            $table->string('district')->nullable(true)->default(null);
            $table->string('microdistrict')->nullable(true)->default(null);

            $table->boolean('has_repair')->nullable(true)->default(0);

            $table->text('description')->nullable(true)->default(null);
            $table->string('title')->default('');

            $table->unsignedDouble('total_area')->nullable(true)->default(null);
            $table->unsignedDouble('total_area_min')->nullable(true)->default(null);
            $table->unsignedDouble('total_area_max')->nullable(true)->default(null);

            $table->unsignedDouble('price_usd')->nullable()->default(null);
            $table->unsignedDouble('price_usd_min')->nullable()->default(null);
            $table->unsignedDouble('price_usd_max')->nullable()->default(null);

            $table->unsignedDouble('price_uah')->nullable()->default(null);
            $table->unsignedDouble('price_uah_min')->nullable()->default(null);
            $table->unsignedDouble('price_uah_max')->nullable()->default(null);

            $table->string('type')->nullable(false);
            $table->json('advert_details')->nullable(false);
            $table->string('property_type')->nullable(true);

            $table->unsignedBigInteger('user_id')->nullable();

            $table->text('notes')->nullable(true)->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advert_requests');
    }
}
