<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $courses = [
            ['name'=>'Mathematics','code'=>'MATH101','credits'=>3],
            ['name'=>'Physics','code'=>'PHYS101','credits'=>4],
            ['name'=>'Chemistry','code'=>'CHEM101','credits'=>4],
            ['name'=>'Biology','code'=>'BIO101','credits'=>3],
            ['name'=>'English','code'=>'ENG101','credits'=>2],
            ['name'=>'History','code'=>'HIST101','credits'=>3],
            ['name'=>'Geography','code'=>'GEO101','credits'=>3],
            ['name'=>'Computer Science','code'=>'CS101','credits'=>4],
            ['name'=>'Economics','code'=>'ECON101','credits'=>3],
            ['name'=>'Philosophy','code'=>'PHIL101','credits'=>2],
            ['name'=>'Psychology','code'=>'PSY101','credits'=>3],
            ['name'=>'Sociology','code'=>'SOC101','credits'=>3],
            ['name'=>'Art','code'=>'ART101','credits'=>2],
            ['name'=>'Music','code'=>'MUS101','credits'=>2],
            ['name'=>'Political Science','code'=>'PSCI101','credits'=>3],
            ['name'=>'Business Studies','code'=>'BUS101','credits'=>3],
            ['name'=>'Accounting','code'=>'ACC101','credits'=>3],
            ['name'=>'Marketing','code'=>'MKT101','credits'=>3],
            ['name'=>'Law','code'=>'LAW101','credits'=>3],
            ['name'=>'Engineering','code'=>'ENGR101','credits'=>4],
            ['name'=>'Medicine','code'=>'MED101','credits'=>5],
            ['name'=>'Nursing','code'=>'NURS101','credits'=>4],
            ['name'=>'Statistics','code'=>'STAT101','credits'=>3],
            ['name'=>'Environmental Science','code'=>'ENV101','credits'=>3],
            ['name'=>'Astronomy','code'=>'AST101','credits'=>3],
        ];

        foreach ($courses as $course) {
            Course::create($course);
        }
    }
}
