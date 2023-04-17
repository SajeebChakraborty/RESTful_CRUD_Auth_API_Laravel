<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

//import the User model
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        //dummy data for inserted into database
        $users=[
            [
                'name'=>'Sajeeb Chakraborty',
                'email'=>'sajeebchakraborty.cse2000@gmail.com',
                'password'=> '123456',

            ],
            [
                'name'=>'Robin Chakraborty',
                'email'=>'robincb.symphony@gmail.com',
                'password'=>'123456',

            ]
        ];

        User::insert($users);

    }
}
