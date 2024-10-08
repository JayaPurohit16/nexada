<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    use HasFactory, SoftDeletes;

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function subscriptionTypes()
    {
        return $this->hasMany(SubscriptionType::class, 'subscription_id', 'id');
    }
}
