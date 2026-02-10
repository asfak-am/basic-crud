<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Enrollment;

class EnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $enrollments = [
            ['student_id'=>1,'course_id'=>1],
            ['student_id'=>2,'course_id'=>1],
            ['student_id'=>3,'course_id'=>2],
            ['student_id'=>4,'course_id'=>2],
            ['student_id'=>5,'course_id'=>3],
            ['student_id'=>6,'course_id'=>3],
            ['student_id'=>7,'course_id'=>4],
            ['student_id'=>8,'course_id'=>5],
            ['student_id'=>9,'course_id'=>6],
            ['student_id'=>10,'course_id'=>7],
            ['student_id'=>11,'course_id'=>8],
            ['student_id'=>12,'course_id'=>9],
            ['student_id'=>13,'course_id'=>10],
            ['student_id'=>14,'course_id'=>11],
            ['student_id'=>15,'course_id'=>12],
            ['student_id'=>16,'course_id'=>13],
            ['student_id'=>17,'course_id'=>14],
            ['student_id'=>18,'course_id'=>15],
            ['student_id'=>19,'course_id'=>16],
            ['student_id'=>20,'course_id'=>17],
            ['student_id'=>21,'course_id'=>18],
            ['student_id'=>22,'course_id'=>19],
            ['student_id'=>23,'course_id'=>20],
            ['student_id'=>24,'course_id'=>21],
            ['student_id'=>25,'course_id'=>22],
        ];

        foreach($enrollments as $enroll){
            Enrollment::create($enroll);
        }
    }
}
