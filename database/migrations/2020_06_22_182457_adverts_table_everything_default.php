<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdvertsTableEverythingDefault extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
         *   user_id          bigint unsigned                         null,
    created_at       timestamp                               null,
    updated_at       timestamp                               null,
    street           varchar(255) collate utf8mb4_unicode_ci not null,
    building         varchar(255) collate utf8mb4_unicode_ci not null,
    city             varchar(255) collate utf8mb4_unicode_ci not null,
    district         varchar(255) collate utf8mb4_unicode_ci not null,
    microdistrict    varchar(255) collate utf8mb4_unicode_ci not null,
    total_area       double unsigned                         not null,
    has_repair       tinyint(1)      default 0               not null,
    description      text collate utf8mb4_unicode_ci         not null,
    title            varchar(255) collate utf8mb4_unicode_ci not null,
    main_image_id    bigint unsigned                         null,
    price_usd        double unsigned                         null,
    price_uah        double unsigned                         null,
    price_per_ms_usd double unsigned                         null,
    price_per_ms_uah double unsigned                         null,
    notes            text                                    null,
    type             varchar(255)                            not null,
    advert_details   json                                    null,
    property_type    varchar(255)                            not null,
    requested        bigint unsigned default 0               not null,
         */
        Schema::table('adverts', function (Blueprint $table) {
            $table->string('street')->nullable()->default(null)->change();
            $table->string('building')->nullable()->default(null)->change();
            $table->string('city')->nullable()->default(null)->change();
            $table->string('district')->nullable()->default(null)->change();
            $table->string('microdistrict')->nullable()->default(null)->change();

            $table->text('description')->nullable()->default(null)->change();

            $table->text('notes')->default(null)->change();
            $table->string('type')->nullable()->default(null)->change();
            $table->string('property_type')->nullable()->default(null)->change();


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
