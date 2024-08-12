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
            $table->string('image')->nullable()->after('description');
            $table->enum('billing_period',[0,1,2])->default(0)->after('amount')->comment('0 => Monthly, 1 => Quarterly, 2=> Yearly');
            $table->integer('discount')->nullable()->after('billing_period');
            $table->integer('amount_of_free_lessons')->nullable()->after('discount');
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
            $table->dropColumn('image');
            $table->dropColumn('billing_period');
            $table->dropColumn('discount');
            $table->dropColumn('amount_of_free_lessons');
        });
    }
};
