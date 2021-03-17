<?php

namespace Database\Seeders;

use App\Models\Editors;
use Illuminate\Database\Seeder;

class EditorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $editors = [
            [
                'id'        => 56964879,
                'name'      => 'TwoAngryGamersTV',
                'role_id'   => 1,
            ],
            [
                'id'        => 4928541,
                'name'      => 'SweptSquash',
                'role_id'   => 1,
            ],
        ];

        foreach ($editors as $editor) {
            Editors::factory()->create($editor);
        }
    }
}
