<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

//Models
use App\Models\User; 

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        
        $user = User::create(['name' => 'Administrator', 'email' => 'admin@admin.com', 'password' => bcrypt('1234567890')]);

        $user->assignRole(1);
    }
}
