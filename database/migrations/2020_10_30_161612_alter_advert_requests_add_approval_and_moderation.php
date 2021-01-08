<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAdvertRequestsAddApprovalAndModeration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('advert_requests', function (Blueprint $table) {
            $table->boolean('approval')->after('updated_at')->nullable(false)->default(true);
            $table->boolean('on_moderation')->after('updated_at')->nullable(false)->default(false);
            $table->boolean('moderated')->after('updated_at')->nullable(false)->default(false);
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
            $table->dropColumn('approval');
            $table->dropColumn('on_moderation');
            $table->dropColumn('moderated');
        });
    }
}
