<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Teacher;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $teachers = [
            ['name'=>'John Doe','email'=>'john@example.com','phone'=>'1234567890','department'=>'Mathematics'],
            ['name'=>'Jane Smith','email'=>'jane@example.com','phone'=>'1234567891','department'=>'Physics'],
            ['name'=>'Robert Brown','email'=>'robert@example.com','phone'=>'1234567892','department'=>'Chemistry'],
            ['name'=>'Emily Davis','email'=>'emily@example.com','phone'=>'1234567893','department'=>'Biology'],
            ['name'=>'William Wilson','email'=>'william@example.com','phone'=>'1234567894','department'=>'English'],
            ['name'=>'Olivia Johnson','email'=>'olivia@example.com','phone'=>'1234567895','department'=>'History'],
            ['name'=>'Michael Miller','email'=>'michael@example.com','phone'=>'1234567896','department'=>'Geography'],
            ['name'=>'Sophia Anderson','email'=>'sophia@example.com','phone'=>'1234567897','department'=>'Computer Science'],
            ['name'=>'James Thomas','email'=>'james@example.com','phone'=>'1234567898','department'=>'Economics'],
            ['name'=>'Isabella Martinez','email'=>'isabella@example.com','phone'=>'1234567899','department'=>'Philosophy'],
            ['name'=>'David Lee','email'=>'david@example.com','phone'=>'1234501230','department'=>'Psychology'],
            ['name'=>'Mia Perez','email'=>'mia@example.com','phone'=>'1234501231','department'=>'Sociology'],
            ['name'=>'Richard Harris','email'=>'richard@example.com','phone'=>'1234501232','department'=>'Art'],
            ['name'=>'Charlotte Clark','email'=>'charlotte@example.com','phone'=>'1234501233','department'=>'Music'],
            ['name'=>'Joseph Lewis','email'=>'joseph@example.com','phone'=>'1234501234','department'=>'Political Science'],
            ['name'=>'Amelia Walker','email'=>'amelia@example.com','phone'=>'1234501235','department'=>'Business Studies'],
            ['name'=>'Thomas Hall','email'=>'thomas@example.com','phone'=>'1234501236','department'=>'Accounting'],
            ['name'=>'Harper Allen','email'=>'harper@example.com','phone'=>'1234501237','department'=>'Marketing'],
            ['name'=>'Charles Young','email'=>'charles@example.com','phone'=>'1234501238','department'=>'Law'],
            ['name'=>'Evelyn Hernandez','email'=>'evelyn@example.com','phone'=>'1234501239','department'=>'Engineering'],
            ['name'=>'Daniel King','email'=>'daniel@example.com','phone'=>'1234501240','department'=>'Medicine'],
            ['name'=>'Abigail Wright','email'=>'abigail@example.com','phone'=>'1234501241','department'=>'Nursing'],
            ['name'=>'Matthew Scott','email'=>'matthew@example.com','phone'=>'1234501242','department'=>'Statistics'],
            ['name'=>'Ella Green','email'=>'ella@example.com','phone'=>'1234501243','department'=>'Environmental Science'],
            ['name'=>'Anthony Adams','email'=>'anthony@example.com','phone'=>'1234501244','department'=>'Astronomy'],
        ];


        foreach ($teachers as $teacher) {
            Teacher::create($teacher);
        }
    }
}
