<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Course;

class Teacher extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'department',
    ];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_teachers', 'teacher_id', 'course_id');
    }
}
