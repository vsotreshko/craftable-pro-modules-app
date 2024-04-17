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
        Schema::table('craftable_pro_users', function (Blueprint $table) {
            $table->text('two_factor_secret_for_refresh')
                ->nullable();

            $table->text('two_factor_recovery_codes_for_refresh')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('craftable_pro_users', function (Blueprint $table) {
           $table->dropColumn(['two_factor_secret_for_refresh', 'two_factor_recovery_codes_for_refresh']);
       });
    }
};
