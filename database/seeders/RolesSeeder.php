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
                'permissions'   => 'Add Users,List Users,Delete Users,Can Delete,Can Edit,Can Download',
            ],
            [
                'name'          => 'Editor',
                'permissions'   => 'Can Edit,Can Download',
            ],
            [
                'name'          => 'User',
                'permissions'   => 'Can Download',
            ],
        ];

        foreach ($roles as $role) {
            Roles::factory()->create($role);
        }
    }
}
