<?php

use Illuminate\Database\Seeder;
use App\Models\Users\Subjects;

class SubjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subjects')->insert([
            ['subject'=>'国語'],
            ['subject'=>'数学'],
            ['subject'=>'英語']
        ]);
        // 国語、数学、英語を追加
    }
}