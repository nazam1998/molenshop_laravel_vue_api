<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $users = User::all();
        foreach ($users as $user) {

            DB::table('profiles')->insert([
                'firstname' => $faker->firstName(),
                'lastname' => $faker->lastName(),
                'picture_path' => 'profile/IMG_20220102_125938.jpg',
                'user_id' => $user->id
            ]);
        }
    }
}
