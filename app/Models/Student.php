<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    public function userInfo()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function parentInfo()
    {
        return $this->hasOne(UserParent::class, 'parent_of_student', 'id');
    }

    public function getFullNameAttribute()
    {
        return $this->userInfo ? $this->userInfo->fullName : '';
    }
}
