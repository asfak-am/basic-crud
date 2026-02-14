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

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'LIKE', "%{$search}%")
              ->orWhere('email', 'LIKE', "%{$search}%")
              ->orWhere('department', 'LIKE', "%{$search}%");
        });
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_teachers', 'teacher_id', 'course_id');
    }
}
