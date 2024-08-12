<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubscriptionType extends Model
{
    use HasFactory, SoftDeletes;

    public function SubscriptionInfo()
    {
        return $this->belongsTo(Subscription::class, 'subscription_id');
    }

    public function getBillingPeriodNameAttribute()
    {
        switch ($this->attributes['billing_period']) {
            case "0":
                return 'Monthly';
            case "1":
                return 'Quarterly';
            case "2":
                return 'Yearly';
            default:
                return '';
        }
    }
}
