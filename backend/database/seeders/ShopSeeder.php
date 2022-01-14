<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        foreach ($users as $index=>$user){
            if($index >0){
                $public = false;
            }else{
                $public = true;
            }
            $profile = Profile::where('user_id', $user->id)->first();
            DB::table('shops')->insert([
                'name' => 'Shop de ' . $profile->firstname . ' ' . $profile->lastname,
                'user_id' => $user->id,
                'public' => $public
            ]);
        }
    }
}
