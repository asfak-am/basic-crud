<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $fillable = [
        'student_id',
        'course_id',
        'enrolled_at',
    ];

      public function scopeSearch($query, $search)
    {
        return $query->whereHas('student', function ($q) use ($search) {
            $q->where('name', 'LIKE', "%{$search}%");
        })->orWhereHas('course', function ($q) use ($search) {
            $q->where('name', 'LIKE', "%{$search}%")
              ->orWhere('code', 'LIKE', "%{$search}%");
        });
    } 

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
