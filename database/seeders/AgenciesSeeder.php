<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

//Models
use App\Models\Agency;

class AgenciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        for($x = 1; $x < 5; ++$x) {

            $agency = new Agency; 
            $agency->name = 'MFO:'.$x;
            $agency->save();
        }
    }
}
