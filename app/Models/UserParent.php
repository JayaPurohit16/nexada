<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserParent extends Model
{
    use HasFactory, SoftDeletes;

    public function userInfo()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function StudentInfo()
    {
        return $this->belongsTo(Student::class, 'parent_of_student');
    }

    public function getFullNameAttribute()
    {
        return $this->userInfo ? $this->userInfo->fullName : '';
    }
}
