<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instrument extends Model
{
    use HasFactory;

    public function skill()
    {
        return $this->hasMany(Skill::class, 'instrument_id');
    }
}
