<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SampleTopics extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0;$i<20;$i++){
            DB::table('topics')->insert([
                'user_id' => '1',
                'title' => 'ゴミの削減について',
                'body' => 'ペットボトルは、捨てるときにかさばりますし、購入頻度を減らしたいのですが、どうしたら環境のためになるのでしょうか。',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ]);
        }
    }
}
