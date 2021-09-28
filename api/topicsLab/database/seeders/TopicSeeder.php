<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TopicSeeder extends Seeder
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
                'title' => 'ゴミの削減について-'.strval($i),
                'body' => 'ペットボトルは、捨てるときにかさばりますし、購入頻度を減らしたいのですが、どうしたら環境のためになるのでしょうか。',
                'created_at' => new DateTime('+'.strval($i).' second'),
                'updated_at' => new DateTime('+'.strval($i).' second')
            ]);
            DB::table('topics')->insert([
                'user_id' => '2',
                'title' => '地球温暖化や豪雨など、世界各地で気候変動の影響-'.strval($i),
                'body' => '気候変動の原因は人間にあると、既に結論付けられたようです。というのも、IPCC（気候変動に関する政府間パネル：Intergovernmental Panel on Climate Change）という組織が、2021年8月6日に第6次評価報告書を公開しました。',
                'created_at' => new DateTime('+'.strval($i).' second'),
                'updated_at' => new DateTime('+'.strval($i).' second')
            ]);
        }

    }
}
