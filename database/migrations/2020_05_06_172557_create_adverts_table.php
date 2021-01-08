<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adverts', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('price')->nullable(false);
            $table->char('price_sign', 3)->nullable(false);
            $table->unsignedDouble('price_per_ms')->default(null);
            $table->char('price_per_ms_sign', 3)->nullable(false);
            $table->unsignedTinyInteger('rooms')->nullable(false);
            $table->unsignedTinyInteger('floor')->default(null);
            $table->unsignedTinyInteger('storeys')->default(null);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adverts');
    }
}
