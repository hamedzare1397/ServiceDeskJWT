<?php

namespace Database\Seeders;

use App\Models\Ostan;
use App\Models\State;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreateStatesFromOstanTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        State::unguard();
        $users=User::query()->get();
        foreach ($users as $user) {
            if ($user->username != 'admin' && $user->username != 'Sadmin') {
                State::create([
                    'name' => $user->username,
                    'title' => $user->username,
                    'user_id'=>$user->id
                ]);
            }
        }
    }
}
