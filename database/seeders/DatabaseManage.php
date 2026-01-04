<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create(['name' => 'admin']);
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);
        $role = Role::create(['name' => 'user']);
        $role->givePermissionTo('view posts');
        $role->givePermissionTo('create posts');
    }

    public function down()
    {
        Role::truncate();
        Permission::truncate();
        DB::table('permission_role')->truncate();
    }

    public function up()
    {
        $this->run();
        if (app()->environment() === 'testing') {
            $this->down();
            for ($i = 0; $i < 10; $i++) {
                $this->run();
                $this->down();
            }
        }
    }

    public function __invoke()
    {
        $this->assertEmpty($permissions);

        if (app()->environment() === 'testing') {
            $this->down();
            for ($i = 0; $i < 10; $i++) {
                $this->run();
                $this->down();
            }
        } else {
            $this->run();
        }
    }
}
class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'name' => 'view posts',
                'label' => 'View Posts'
            ],
            [
                'name' => 'create posts',
                'label' => 'Create Posts'
            ],
            [
                'name' => 'edit posts',
                'label' => 'Edit Posts'
            ],
            [
                'name' => 'delete posts',
                'label' => 'Delete Posts'
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }

    public function down()
    {
        Permission::truncate();
    }

    public function up()
    {
        $this->run();
        if (app()->environment() === 'testing') {
            $this->down();
            for ($i = 0; $i < 10; $i++) {
                $this->run();
                $this->down();
            }
        }
    }

    public function __invoke()
    {
        $this->assertEmpty($permissions);

        if (app()->environment() === 'testing') {
            $this->down();
            for ($i = 0; $i < 10; $i++) {
                $this->run();
                $this->down();
            }
        } else {
            $this->run();
        }
    }
}

?>
