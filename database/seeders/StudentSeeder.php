<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $students = [
            ['name'=>'Alice Johnson','email'=>'alice@example.com','phone'=>'1111111111','joining_date'=>'2023-01-10'],
            ['name'=>'Bob Smith','email'=>'bob@example.com','phone'=>'1111111112','joining_date'=>'2023-02-12'],
            ['name'=>'Charlie Brown','email'=>'charlie@example.com','phone'=>'1111111113','joining_date'=>'2023-03-15'],
            ['name'=>'Diana Prince','email'=>'diana@example.com','phone'=>'1111111114','joining_date'=>'2023-04-20'],
            ['name'=>'Ethan Hunt','email'=>'ethan@example.com','phone'=>'1111111115','joining_date'=>'2023-05-05'],
            ['name'=>'Fiona Gallagher','email'=>'fiona@example.com','phone'=>'1111111116','joining_date'=>'2023-06-10'],
            ['name'=>'George Martin','email'=>'george@example.com','phone'=>'1111111117','joining_date'=>'2023-07-18'],
            ['name'=>'Hannah Lee','email'=>'hannah@example.com','phone'=>'1111111118','joining_date'=>'2023-08-22'],
            ['name'=>'Ian Somerhalder','email'=>'ian@example.com','phone'=>'1111111119','joining_date'=>'2023-09-01'],
            ['name'=>'Julia Roberts','email'=>'julia@example.com','phone'=>'1111111120','joining_date'=>'2023-10-10'],
            ['name'=>'Kevin Spacey','email'=>'kevin@example.com','phone'=>'1111111121','joining_date'=>'2023-11-15'],
            ['name'=>'Laura Palmer','email'=>'laura@example.com','phone'=>'1111111122','joining_date'=>'2023-12-01'],
            ['name'=>'Mark Twain','email'=>'mark@example.com','phone'=>'1111111123','joining_date'=>'2023-01-05'],
            ['name'=>'Nancy Drew','email'=>'nancy@example.com','phone'=>'1111111124','joining_date'=>'2023-02-14'],
            ['name'=>'Oscar Wilde','email'=>'oscar@example.com','phone'=>'1111111125','joining_date'=>'2023-03-19'],
            ['name'=>'Pam Beesly','email'=>'pam@example.com','phone'=>'1111111126','joining_date'=>'2023-04-23'],
            ['name'=>'Quentin Tarantino','email'=>'quentin@example.com','phone'=>'1111111127','joining_date'=>'2023-05-27'],
            ['name'=>'Rachel Green','email'=>'rachel@example.com','phone'=>'1111111128','joining_date'=>'2023-06-30'],
            ['name'=>'Steve Rogers','email'=>'steve@example.com','phone'=>'1111111129','joining_date'=>'2023-07-08'],
            ['name'=>'Tina Fey','email'=>'tina@example.com','phone'=>'1111111130','joining_date'=>'2023-08-12'],
            ['name'=>'Ulysses Grant','email'=>'ulysses@example.com','phone'=>'1111111131','joining_date'=>'2023-09-20'],
            ['name'=>'Victoria Beckham','email'=>'victoria@example.com','phone'=>'1111111132','joining_date'=>'2023-10-25'],
            ['name'=>'Walter White','email'=>'walter@example.com','phone'=>'1111111133','joining_date'=>'2023-11-30'],
            ['name'=>'Xander Cage','email'=>'xander@example.com','phone'=>'1111111134','joining_date'=>'2023-12-15'],
            ['name'=>'Yvonne Strahovski','email'=>'yvonne@example.com','phone'=>'1111111135','joining_date'=>'2023-01-20'],
        ];

        foreach($students as $student){
            Student::create($student);
        }
    }
}
