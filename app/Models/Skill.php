<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Skill extends Model
{
    use HasFactory, SoftDeletes;

    public function instrument()
    {
        return $this->belongsTo(Instrument::class, 'instrument_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'last_changes_by');
    }
}
