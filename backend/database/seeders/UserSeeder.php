<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'email'=>'nazamfr1998@gmail.com',
            'password'=>Hash::make('nazamfr1998@gmail.com'),
        ]);
        User::factory()->count(10)->create();
    }
}
