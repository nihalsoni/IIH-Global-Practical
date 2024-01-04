<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Skill;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $skills = ['Programming', 'Web Development', 'Database Management', 'UI/UX Design', 'Project Management'];

        foreach ($skills as $skill) {
            Skill::create(['name' => $skill]);
        }
    }
}
