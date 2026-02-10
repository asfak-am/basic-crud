<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Enrollment;
use App\Models\Teacher;


class Course extends Model
{
    protected $fillable = [
        'name',
        'code',
        'credits',
    ];

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'course_teachers', 'teacher_id', 'course_id');
    }
}
