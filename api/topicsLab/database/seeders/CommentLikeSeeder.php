<?php

namespace Database\Seeders;
use DateTime;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentLikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('comment_likes')->insert([
        'user_id' => '2',
        'comment_id' => '1',
        'created_at' => new DateTime(),
        'updated_at' => new DateTime(),
        ]);
    }
}
