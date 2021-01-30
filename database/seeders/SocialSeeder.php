<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SocialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('socials')->insert([
            'name' => 'facebook',
            'icon' => 'fa-facebook-f',
            'link' => 'https://facebook.com/futurx',
            'status' => '1',
        ]);
        DB::table('socials')->insert([
            'name' => 'twitter',
            'icon' => 'fa-twitter',
            'link' => 'https://twitter.com/futurx',
            'status' => '1',
        ]);
        DB::table('socials')->insert([
            'name' => 'instagram',
            'icon' => 'fa-instagram',
            'link' => 'https://instagram.com/futurx',
            'status' => '1',
        ]);
        DB::table('socials')->insert([
            'name' => 'github',
            'icon' => 'fa-github',
            'link' => 'https://github.com/futurx',
            'status' => '1',
        ]);
        DB::table('socials')->insert([
            'name' => 'Medium',
            'icon' => 'fa-medium-m',
            'link' => 'https://medium.com/@futurx',
            'status' => '1',
        ]);
        DB::table('socials')->insert([
            'name' => 'YouTube',
            'icon' => 'fa-youtube',
            'link' => 'https://github.com/channel/futurx',
            'status' => '1',
        ]);
        DB::table('socials')->insert([
            'name' => 'Reddit',
            'icon' => 'fa-reddit',
            'link' => 'https://reddit.com/u/futurx',
            'status' => '1',
        ]);
    }
}
