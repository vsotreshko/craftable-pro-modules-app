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
        Schema::create('craftable_pro_users', function (Blueprint $table) {
            $table->id();

            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email');
            $table->string('password');

            $table->timestamp('invitation_sent_at')->nullable();
            $table->timestamp('invitation_accepted_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('last_active_at')->nullable();

            $table->string('locale')->default(config('app.locale', 'en'));
            $table->boolean('active')->default(true);

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        // TODO rethink this concept maybe?
        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");
        if ($driver == 'pgsql') {
            Schema::table('craftable_pro_users', function (Blueprint $table) {
                DB::statement('CREATE UNIQUE INDEX craftable_pro_users_email_null_deleted_at ON craftable_pro_users (email) WHERE deleted_at IS NULL;');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('craftable_pro_users');
    }
};
