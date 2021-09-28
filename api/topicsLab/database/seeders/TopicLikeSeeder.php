<?php

namespace Database\Seeders;
use DateTime;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TopicLikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('topic_likes')->insert([
        'user_id' => '2',
        'topic_id' => '1',
        'created_at' => new DateTime(),
        'updated_at' => new DateTime(),
        ]);
    }
}
