<?php

use Illuminate\Database\Seeder;
use App\Models\Users\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'over_name'=>'高橋',
                'under_name'=>'杏子',
                'over_name_kana'=>'タカハシ',
                'under_name_kana'=>'キョウコ',
                'mail_address'=>'taka@mail.com',
                'sex'=>'2',
                'birth_day'=>'1999-08-24',
                'role'=>'3',
                'password'=>'takakyoko'
            ]
        ]);
    }
}