<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $saveuser=new User();
        $saveuser->name = "Catalina";
        $saveuser->email = "catalina@agrosupplyltd.com";
        $saveuser->password = bcrypt("password@");      
        $saveuser->remember_token = str_random(32);
        $saveuser->save();
    }
}
