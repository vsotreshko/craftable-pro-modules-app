<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $defaultPermissions = collect([
            // view admin as a whole
            'craftable-pro',

            // manage translations
            'craftable-pro.translation.index',
            'craftable-pro.translation.edit',
            'craftable-pro.translation.rescan',
            'craftable-pro.translation.publish',
            'craftable-pro.translation.export',
            'craftable-pro.translation.import',

            // manage users (access)
            'craftable-pro.craftable-pro-user.index',
            'craftable-pro.craftable-pro-user.create',
            'craftable-pro.craftable-pro-user.show',
            'craftable-pro.craftable-pro-user.edit',
            'craftable-pro.craftable-pro-user.destroy',
            'craftable-pro.craftable-pro-user.impersonal-login',

            // media
            'craftable-pro.media.index',
            'craftable-pro.media.upload',
            'craftable-pro.media.destroy',

            // permissions
            'craftable-pro.role.index',
            'craftable-pro.role.edit',

            // manage tags (access)
            'craftable-pro.tag.index',
            'craftable-pro.tag.store',

            // settings
            'craftable-pro.settings.edit',

            // permissions
            'craftable-pro.permission.index',
            'craftable-pro.permission.edit'
        ]);

        $adminRoleId = DB::table('roles')->insertGetId([
            'name' => 'Administrator',
            'guard_name' => 'craftable-pro',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $defaultPermissions->each(function ($permission) use ($adminRoleId) {
            $permissionId = DB::table('permissions')->insertGetId([
                'name' => $permission,
                'guard_name' => 'craftable-pro',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            DB::table('role_has_permissions')->insert([
                'permission_id' => $permissionId,
                'role_id' => $adminRoleId,
            ]);
        });

        // let's create a default Guest role in case self-registration is enabled
        $guestRoleId = DB::table('roles')->insertGetId([
            'name' => 'Guest',
            'guard_name' => 'craftable-pro',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => DB::table('permissions')
                ->where('name', '=', 'craftable-pro')
                ->where('guard_name', '=', 'craftable-pro')
                ->value('id'),
            'role_id' => $guestRoleId,
        ]);

        app()['cache']->forget(config('permission.cache.key'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $guestRole = DB::table('roles')->where('name', 'Guest')->where('guard_name', 'craftable-pro')->first();
        DB::table('role_has_permissions')
            ->where('role_id', $guestRole->id)
            ->delete();
        DB::table('roles')->where('id', $guestRole->id)->delete();

        $adminRole = DB::table('roles')->where('name', 'Administrator')->where('guard_name', 'craftable-pro')->first();
        DB::table('role_has_permissions')
            ->where('role_id', $adminRole->id)
            ->delete();
        DB::table('roles')->where('id', $adminRole->id)->delete();

        $this->defaultPermissions->each(function ($permission){
            $permissionItem = DB::table('permissions')->where([
                'name' => $permission,
                'guard_name' => 'craftable-pro'
            ])->first();

            if ($permissionItem !== null) {
                DB::table('permissions')->where('id', $permissionItem->id)->delete();
                DB::table('model_has_permissions')->where('permission_id', $permissionItem->id)->delete();
            }
        });
        app()['cache']->forget(config('permission.cache.key'));
    }
};
