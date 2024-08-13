<?php

namespace Database\Seeders;

use App\Models\CmsSettting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CMSSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $input = [
            ['key' => 'website_logo', 'value' => null],
            ['key' => 'favicon_logo', 'value' => null],
            ['key' => 'facebook_link', 'value' => 'https://www.facebook.com'],
            ['key' => 'instagram_link', 'value' => 'https://www.instagram.com'],
            ['key' => 'twitter_link', 'value' => 'https://www.twitter.com'],
            ['key' => 'youtube_link', 'value' => 'https://www.youtube.com'],
        ];

        foreach ($input as $data) {
            $key = CmsSettting::where('key', $data['key'])->first();
            if (isset($key)) {
                $key->update($data);
            } else {
                CmsSettting::create($data);
            }
        }
    }
}
