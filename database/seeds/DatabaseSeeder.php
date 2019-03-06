<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(ModulesSeeder::class);
        $this->call(LessonSeeder::class);
        $this->call(ReviewMaterialSeeder::class);
        $this->call(QuestionsSeeder::class);
        $this->call(StudentTestSeeder::class);
        $this->call(AttendanceSeeder::class);
        $this->call(SectionsSeeder::class);
        $this->call(DrillSeeder::class);
    }
}
