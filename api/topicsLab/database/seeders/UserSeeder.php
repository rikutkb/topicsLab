<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'tanaka',
            'email' => 'tanaka@example.com',
            'password' => Hash::make('password'),
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
            'intro' => 'test',
        ]);
        DB::table('users')->insert([
            'name' => 'yamada',
            'email' => 'yamada@example.com',
            'password' => Hash::make('password'),
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
            'intro' => 'test',
        ]);
        DB::table('users')->insert([
            'name' => 'katou',
            'email' => 'katou@example.com',
            'password' => Hash::make('password'),
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
            'intro' => 'test',
        ]);
        DB::table('users')->insert([
            'name' => 'iwasaki',
            'email' => 'iwasaki@example.com',
            'password' => Hash::make('password'),
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
            'intro' => 'test',
        ]);

        for($i = 1;$i<25;$i++){
            DB::table('users')->insert([
                'name' => 'test-'.strval($i),
                'email' => 'test'.strval($i).'@example.com',
                'password' => Hash::make('password'),
                'intro' => 'test'.strval($i),
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ]);
        }


    }
}
