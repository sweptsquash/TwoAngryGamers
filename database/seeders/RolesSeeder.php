<?php

namespace Database\Seeders;

use App\Models\Roles;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name'          => 'Admin',
                'permissions'   => 'Create Editors,Edit Editors,List Editors,Delete Editors,List Videos,Delete Videos,Can Download',
            ],
            [
                'name'          => 'Editor',
                'permissions'   => 'List Videos,Can Download',
            ],
            [
                'name'          => 'User',
                'permissions'   => 'List Videos,Can Download',
            ],
        ];

        foreach ($roles as $role) {
            Roles::factory()->create($role);
        }
    }
}
