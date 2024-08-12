<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->longText('description')->nullable()->after('name');
            $table->integer('lesson_per_week')->nullable()->after('description');
            $table->integer('time')->nullable()->after('lesson_per_week');
            $table->enum('new_sign_up_allowed',[0,1])->default(0)->after('amount')->comment('0 => false(no), 1 => true(yes)');
            $table->unsignedBigInteger('location_id')->nullable()->after('new_sign_up_allowed');
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropForeign(['location_id']);
            $table->dropColumn('location_id');
            $table->dropColumn('new_sign_up_allowed');
            $table->dropColumn('time');
            $table->dropColumn('lesson_per_week');
            $table->dropColumn('description');
        });
    }
};
