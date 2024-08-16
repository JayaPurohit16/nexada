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
            case "1":
                return '1 Month';
            case "2":
                return '2 Months';
            case "3":
                return '3 Months';
            case "4":
                return '4 Months';
            case "5":
                return '5 Months';
            case "6":
                return '6 Months';
            case "7":
                return '7 Months';
            case "8":
                return '8 Months';
            case "9":
                return '9 Months';
            case "10":
                return '10 Months';
            case "11":
                return '11 Months';
            case "12":
                return '12 Months';
            default:
                return '';
        }
    }
}
