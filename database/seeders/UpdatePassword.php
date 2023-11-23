<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdatePassword extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->withProgressBar(User::all(),function ($user){
            $user->password = bcrypt($user->pass);
            $user->username = $user->user;
            $user->save();
        });
    }
}
