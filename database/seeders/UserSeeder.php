<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //adding an admin firstly
        DB::table('users')->insert([
            'name' => 'ilker',
            'email' => 'kocatepeilker@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$ngPeW0nJPVgUcX7wBTH8EOfytI0Vw1s3zIwaypVvJmyNXpNgxM61q', // password
            'remember_token' => Str::random(10),
            'refer_hash' => strtoupper(Str::random(10)),
            'telegram' => 1079787804,
            'created_at' => now(),
        ]);

        $role = Role::create(['name' => 'Super Admin']);
        User::find(1)->assignRole('Super Admin');
    }
}
