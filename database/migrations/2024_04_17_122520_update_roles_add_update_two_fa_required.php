<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
       {
           Schema::table('roles', function (Blueprint $table) {
               $table->boolean('two_factor_auth_required')->default(false);
           });
       }

   public function down(): void
          {
              Schema::table('roles', function (Blueprint $table) {
                  $table->dropColumn('two_factor_auth_required');
              });
          }
};
