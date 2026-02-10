<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CourseTeacher;

class CourseTeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $assignments = [
            ['course_id'=>1,'teacher_id'=>1],
            ['course_id'=>1,'teacher_id'=>2],
            ['course_id'=>2,'teacher_id'=>3],
            ['course_id'=>2,'teacher_id'=>4],
            ['course_id'=>3,'teacher_id'=>5],
            ['course_id'=>3,'teacher_id'=>6],
            ['course_id'=>4,'teacher_id'=>7],
            ['course_id'=>5,'teacher_id'=>8],
            ['course_id'=>6,'teacher_id'=>9],
            ['course_id'=>7,'teacher_id'=>10],
            ['course_id'=>8,'teacher_id'=>11],
            ['course_id'=>9,'teacher_id'=>12],
            ['course_id'=>10,'teacher_id'=>13],
            ['course_id'=>11,'teacher_id'=>14],
            ['course_id'=>12,'teacher_id'=>15],
            ['course_id'=>13,'teacher_id'=>16],
            ['course_id'=>14,'teacher_id'=>17],
            ['course_id'=>15,'teacher_id'=>18],
            ['course_id'=>16,'teacher_id'=>19],
            ['course_id'=>17,'teacher_id'=>20],
            ['course_id'=>18,'teacher_id'=>21],
            ['course_id'=>19,'teacher_id'=>22],
            ['course_id'=>20,'teacher_id'=>23],
            ['course_id'=>21,'teacher_id'=>24],
            ['course_id'=>22,'teacher_id'=>25],
        ];

        foreach($assignments as $assign){
            CourseTeacher::create($assign);
        }
    }
}
