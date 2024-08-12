<?php

namespace Database\Seeders;

use App\Models\Location;
use App\Models\Subscription;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $locations = Location::get();
        foreach($locations as $location){
            $subscription = new Subscription();
            $subscription->name = "Basic Package";
            $subscription->description = "Basic package description";
            $subscription->lesson_per_week = 3;
            $subscription->time = 1;
            $subscription->amount = 100;
            $subscription->billing_period = "0";
            $subscription->discount = 0;
            $subscription->amount_of_free_lessons = 1;
            $subscription->new_sign_up_allowed = "0";
            $subscription->location_id = $location->id;
            $subscription->save();

            $subscription = new Subscription();
            $subscription->name = "Family Discount";
            $subscription->description = "Family discount description";
            $subscription->lesson_per_week = 4;
            $subscription->time = 2;
            $subscription->amount = 150;
            $subscription->billing_period = "0";
            $subscription->discount = 0;
            $subscription->amount_of_free_lessons = 2;
            $subscription->new_sign_up_allowed = "0";
            $subscription->location_id = $location->id;
            $subscription->save();

            $subscription = new Subscription();
            $subscription->name = "Double Package";
            $subscription->description = "Double package description";
            $subscription->lesson_per_week = 5;
            $subscription->time = 3;
            $subscription->amount = 200;
            $subscription->billing_period = "0";
            $subscription->discount = 0;
            $subscription->amount_of_free_lessons = 3;
            $subscription->new_sign_up_allowed = "0";
            $subscription->location_id = $location->id;
            $subscription->save();

        }
    }
}
