<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('comments')->insert([
            'user_id' => '2',
            'topic_id' => '1',
            'body' => '水筒を使ってゴミや購入頻度をへらすことが一番かなと思います。',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('comments')->insert([
            'user_id' => '2',
            'topic_id' => '2',
            'body' => "やっぱり、いまの技術力で、\nどうにかしないと。",
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('comments')->insert([
            'user_id' => '2',
            'topic_id' => '1',
            'body' => "やっぱり、いまの技術力で、\nどうにかしないと。",
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('comments')->insert([
            'user_id' => '3',
            'topic_id' => '1',
            'body' => "買い物などを減らすことが重要だとお思います。",
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('comments')->insert([
            'user_id' => '4',
            'topic_id' => '1',
            'body' => "買い物などを減らすことが重要だとお思います。",
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);

        for($i = 0;$i<5;$i++){

            DB::table('comments')->insert([
                'user_id' => strval(20+$i),
                'topic_id' => strval(20+$i),
                'body' => "買い物などを減らすことが重要だとお思います。",
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ]);
            DB::table('comments')->insert([
                'user_id' => strval(21+$i),
                'topic_id' => strval(20+$i),
                'body' => "買い物などを減らすことが重要だとお思います。",
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ]);
        }
    }
}
